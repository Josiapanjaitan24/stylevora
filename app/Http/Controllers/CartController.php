<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart items.
     */
    public function index()
    {
        $cartItems = auth()->user()->carts()->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update cart item.
     */
    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > 0) {
            $cart->update(['quantity' => $request->quantity]);
        }

        return redirect()->back()->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang!');
    }

    /**
     * Clear all cart items.
     */
    public function clear()
    {
        auth()->user()->carts()->delete();
        
        return redirect()->back()->with('success', 'Keranjang dikosongkan!');
    }

    /**
     * Get cart count.
     */
    public function count()
    {
        return auth()->user()->carts()->sum('quantity');
    }
}
