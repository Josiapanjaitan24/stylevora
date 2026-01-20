<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Models\Order;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use App\Policies\AdminPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        
        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}
