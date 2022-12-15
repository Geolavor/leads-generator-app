<?php
namespace LeadBrowser\Extractor\Providers;

use Illuminate\Support\ServiceProvider;

/**
* ExtractorServiceProvider
*/
class ExtractorServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');
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