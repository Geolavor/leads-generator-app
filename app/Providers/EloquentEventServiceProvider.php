<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Organization\Observers\OrganizationObserver;
use LeadBrowser\Result\Observers\ResultObserver;

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Organization::observe(OrganizationObserver::class);
        Result::observe(ResultObserver::class);
    }
}
