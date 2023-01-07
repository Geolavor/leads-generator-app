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
        'employee.create.after' => [
            'LeadBrowser\Admin\Listeners\Employee@linkToEmail'
        ],

        'lead.create.after' => [
            'LeadBrowser\Admin\Listeners\Lead@linkToEmail'
        ],
    ];
}