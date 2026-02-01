<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\Cart;
use App\Models\Order;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS di production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Policies
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}