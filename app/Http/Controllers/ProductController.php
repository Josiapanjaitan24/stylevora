<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the products listing.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a single product.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->where('is_active', true)
                                  ->limit(4)
                                  ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
