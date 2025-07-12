<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // You can register any custom gates here if needed
    }
}
