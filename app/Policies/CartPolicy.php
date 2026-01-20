<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cart;

class CartPolicy
{
    /**
     * Determine if user can update the cart item.
     */
    public function update(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }

    /**
     * Determine if user can delete the cart item.
     */
    public function delete(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }
}
