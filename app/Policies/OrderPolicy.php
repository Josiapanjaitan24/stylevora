<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Determine if user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine if user can update the order.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }
}
