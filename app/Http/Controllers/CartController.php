<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        
        $cart = session('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)),
            ];
        }
        
        session(['cart' => $cart]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to your gear bag',
                'cart_count' => count($cart),
                'cart_total' => number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity'])),
                'html' => view('partials.cart-drawer-items')->render()
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$request->id])) {
            $productName = $cart[$request->id]['name'];
            unset($cart[$request->id]);
            session(['cart' => $cart]);
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from bag',
                'cart_count' => count($cart),
                'cart_total' => number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity'])),
                'html' => view('partials.cart-drawer-items')->render()
            ]);
        }
        
        return redirect()->back()->with('success', 'Item removed from gear bag');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = null;
        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = \App\Models\Coupon::where('code', session('coupon'))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon');
            }
        }

        $total = max(0, $subtotal - $discount);
        
        return view('checkout', compact('cart', 'subtotal', 'discount', 'total', 'coupon'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        
        $coupon = \App\Models\Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid coupon code');
        }

        if (!$coupon->isValid()) {
            return redirect()->back()->with('error', 'Coupon has expired or reached its limit');
        }

        session(['coupon' => $coupon->code]);

        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed');
    }
}
