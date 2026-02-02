<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'customer_postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery,online',
            'notes' => 'nullable|string',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = null;
        $discountAmount = 0;
        $discountType = 'fixed';
        if (session()->has('coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('coupon'))->first();
            if ($coupon && $coupon->isValid()) {
                $discountAmount = $coupon->calculateDiscount($subtotal);
                $discountType = $coupon->type;
                
                // Increment use count
                $coupon->increment('used_count');
            }
        }

        $tax = 0;
        $shipping = 0;
        $total = max(0, $subtotal - $discountAmount + $tax + $shipping);

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'order_type' => 'online',
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'customer_postal_code' => $validated['customer_postal_code'] ?? null,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount_amount' => $discountAmount,
            'discount_type' => $discountType,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'cost_price' => $product ? $product->cost_price : 0,
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Deduct stock
            if ($product) {
                $product->decrement('stock_quantity', $item['quantity']);
                
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => null, // Guest or customer order
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference' => $order->order_number,
                    'notes' => 'Online Order',
                ]);
            }
        }

        // Clear cart and coupon
        session()->forget(['cart', 'coupon']);
        
        // Store customer email in session for account access
        session(['customer_email' => $validated['customer_email']]);

        return redirect()->route('order.confirmation', $order->id);
    }

    public function confirmation($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order-confirmation', compact('order'));
    }
}
