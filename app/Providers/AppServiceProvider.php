<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        // 🔒 Force HTTPS di production (Railway)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 🛡️ Policies
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);

        // 👑 Admin gate
        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}