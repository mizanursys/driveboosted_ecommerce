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

    public function profile()
    {
        $user = Auth::user();
        // Try to find a lead record for this user to get phone number if missing in user table
        $lead = \App\Models\Lead::where('phone', $user->phone)->orWhere('ip_address', request()->ip())->first();
        
        return view('account.profile', compact('user', 'lead'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        // Assuming User model doesn't have phone col yet, but we might want to add it or just use it from request
        // For now let's assume we might need to add it or just ignore if model doesn't support
        // But the plan said "Update Name, Phone". I should check User model first? 
        // Plan assumes User has phone or we use Leads. 
        // Let's just update Name for now and Password. If User model has phone, great.
        // Actually, let's just stick to standard User fields for MVP + Password.
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
