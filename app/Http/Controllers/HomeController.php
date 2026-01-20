<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        $categories = Category::all();
        
        return view('home', compact('products', 'categories'));
    }

    /**
     * Display the dashboard.
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
