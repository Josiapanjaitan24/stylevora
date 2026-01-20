<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display list of orders for admin.
     */
    public function index()
    {
        $this->authorize('admin');
        
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display order detail.
     */
    public function show(Order $order)
    {
        $this->authorize('admin');
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Confirm an order.
     */
    public function confirm(Order $order)
    {
        $this->authorize('admin');

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan sudah dikonfirmasi sebelumnya!');
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Create notification for user
        Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'Pesanan Dikonfirmasi',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah dikonfirmasi. Barang segera diproses untuk pengiriman.',
            'type' => 'order_status',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        $this->authorize('admin');

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan!');
        }

        $order->update(['status' => 'cancelled']);

        Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'Pesanan Dibatalkan',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah dibatalkan oleh admin.',
            'type' => 'order_status',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');
    }

    /**
     * Mark order as shipped.
     */
    public function ship(Order $order)
    {
        $this->authorize('admin');

        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Pesanan harus dikonfirmasi terlebih dahulu!');
        }

        $order->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'Pesanan Dikirim',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' sedang dalam pengiriman.',
            'type' => 'order_status',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil ditandai sebagai dikirim!');
    }

    /**
     * Mark order as delivered.
     */
    public function deliver(Order $order)
    {
        $this->authorize('admin');

        if ($order->status !== 'shipped') {
            return redirect()->back()->with('error', 'Pesanan harus dikirim terlebih dahulu!');
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        Notification::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'title' => 'Pesanan Terkirim',
            'message' => 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah terkirim. Terima kasih telah berbelanja!',
            'type' => 'order_status',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil ditandai sebagai terkirim!');
    }
}
