<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosSession;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $activeSession = PosSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();

        $categories = Category::all();
        $products = Product::where('stock_quantity', '>', 0)->get();

        return view('pos.index', compact('activeSession', 'categories', 'products'));
    }

    public function openSession(Request $request)
    {
        $request->validate([
            'opening_cash' => 'required|numeric|min:0',
        ]);

        PosSession::create([
            'user_id' => Auth::id(),
            'opened_at' => now(),
            'opening_cash' => $request->opening_cash,
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', 'POS Session opened successfully');
    }

    public function closeSession(Request $request)
    {
        $session = PosSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->firstOrFail();

        $request->validate([
            'closing_cash' => 'required|numeric|min:0',
        ]);

        $expectedCash = $session->opening_cash + $session->orders()->sum('total');

        $session->update([
            'closed_at' => now(),
            'closing_cash' => $request->closing_cash,
            'expected_cash' => $expectedCash,
            'status' => 'closed',
        ]);

        return redirect()->back()->with('success', 'POS Session closed. Difference: ৳' . ($request->closing_cash - $expectedCash));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'paid_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:fixed,percentage',
            'payment_method' => 'required|string',
        ]);

        $activeSession = PosSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->firstOrFail();

        return DB::transaction(function () use ($request, $activeSession) {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $discount = 0;
            if ($request->discount_amount) {
                $discount = $request->discount_type === 'percentage' 
                    ? ($subtotal * ($request->discount_amount / 100)) 
                    : $request->discount_amount;
            }

            $total = $subtotal - $discount;

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'order_type' => 'pos',
                'pos_session_id' => $activeSession->id,
                'customer_name' => $request->customer_name ?? 'POS Customer',
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'subtotal' => $subtotal,
                'discount_amount' => $request->discount_amount ?? 0,
                'discount_type' => $request->discount_type ?? 'fixed',
                'total' => $total,
                'paid_amount' => $request->paid_amount,
                'change_amount' => max(0, $request->paid_amount - $total),
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'cost_price' => $product->cost_price,
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Update stock and create movement record
                $product->decrement('stock_quantity', $item['quantity']);
                
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference' => $order->order_number,
                    'notes' => 'POS Sale',
                ]);
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'redirect' => route('pos.receipt', $order->id)
            ]);
        });
    }

    public function receipt($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('pos.receipt', compact('order'));
    }
}
