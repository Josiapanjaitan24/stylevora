<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $this->authorize('admin');
        
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total_price');
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $confirmedRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])->sum('total_price');
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalRevenue', 'confirmedOrders', 'confirmedRevenue', 'cancelledOrders', 'recentOrders'));
    }
}
