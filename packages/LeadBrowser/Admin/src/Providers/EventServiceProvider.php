<?php

namespace LeadBrowser\Admin\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'person.create.after' => [
            'LeadBrowser\Admin\Listeners\Person@linkToEmail'
        ],

        'lead.create.after' => [
            'LeadBrowser\Admin\Listeners\Lead@linkToEmail'
        ],
    ];
}