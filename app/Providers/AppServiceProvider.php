<?php

namespace App\Providers;

use LeadBrowser\Admin\Http\Resources\ResultResource;
use LeadBrowser\User\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ResultResource::withoutWrapping();
        Cashier::useCustomerModel(User::class);
    }
}
