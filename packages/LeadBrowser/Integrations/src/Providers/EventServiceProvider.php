<?php

namespace LeadBrowser\Integrations\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \SocialiteProviders\SalesForce\SalesForceExtendSocialite::class.'@handle',
            \SocialiteProviders\Zoho\ZohoExtendSocialite::class.'@handle',
            \SocialiteProviders\Pipedrive\PipedriveExtendSocialite::class.'@handle',
            \SocialiteProviders\Intercom\IntercomExtendSocialite::class.'@handle',
        ],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
