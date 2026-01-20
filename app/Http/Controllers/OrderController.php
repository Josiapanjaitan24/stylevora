<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Display order detail.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Create a new order from cart.
     */
    public function create()
    {
        $cartItems = auth()->user()->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        return view('orders.create', compact('cartItems'));
    }

    /**
     * Store order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:qris,transfer_bank,cod',
        ]);

        $cartItems = auth()->user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . Str::random(10) . '-' . time(),
            'total_price' => $totalPrice,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Create notification
        Notification::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'title' => 'Pesanan Dibuat',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah dibuat.',
            'type' => 'order_status',
        ]);

        auth()->user()->carts()->delete();

        return redirect()->route('orders.payment', $order)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Display payment page for order.
     */
    public function payment(Order $order)
    {
        $this->authorize('view', $order);
        
        return view('orders.payment', compact('order'));
    }

    /**
     * Cancel order.
     */
    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan!');
        }

        $order->update(['status' => 'cancelled']);

        Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'Pesanan Dibatalkan',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah dibatalkan.',
            'type' => 'order_status',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
