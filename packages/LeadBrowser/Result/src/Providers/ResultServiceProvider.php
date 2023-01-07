<?php

namespace LeadBrowser\Result\Providers;

use Illuminate\Support\ServiceProvider;

/**
* ResultServiceProvider
*/
class ResultServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        
    }
}