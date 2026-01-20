<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display user notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function read($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        if ($notification->order_id) {
            return redirect()->route('orders.show', $notification->order_id);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read.
     */
    public function readAll()
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca!');
    }

    /**
     * Get unread notifications count.
     */
    public function unreadCount()
    {
        return auth()->user()->notifications()->where('is_read', false)->count();
    }
}
