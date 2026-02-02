<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalOrders = Order::where('customer_email', $user->email)->count();
        $pendingOrders = Order::where('customer_email', $user->email)->where('status', 'pending')->count();
        $completedOrders = Order::where('customer_email', $user->email)->where('status', 'completed')->count();
        $recentOrders = Order::where('customer_email', $user->email)->latest()->take(5)->get();

        return view('account.dashboard', compact('totalOrders', 'pendingOrders', 'completedOrders', 'recentOrders', 'user'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('customer_email', $user->email)->latest()->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $user = Auth::user();
        $order = Order::with('items.product')->where('customer_email', $user->email)->findOrFail($id);

        return view('account.order-detail', compact('order'));
    }
}
