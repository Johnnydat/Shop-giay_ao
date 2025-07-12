<?php
// app/Policies/OrderPolicy.php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return bool
     */
    public function view(User $user, Order $order)
    {
        // Example: A user can view their own orders
        return $user->id === $order->user_id;
    }

    /**
     * Determine if the user can update the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return bool
     */
    public function update(User $user, Order $order)
    {
        // Example: A user can update their own orders if they are in the 'pending' or 'processing' status
        return $user->id === $order->user_id && in_array($order->status, ['pending', 'processing']);
    }
}
