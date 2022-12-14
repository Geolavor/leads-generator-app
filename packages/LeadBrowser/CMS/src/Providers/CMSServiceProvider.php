<?php

namespace LeadBrowser\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use LeadBrowser\CMS\Providers\ModuleServiceProvider;

class CMSServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}