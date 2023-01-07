<?php

return [
    'modules' => [
        \LeadBrowser\Activity\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Admin\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Attribute\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Organization\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Core\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Mailbox\Providers\ModuleServiceProvider::class,
        \LeadBrowser\EmailTemplate\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Lead\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Product\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Quote\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Tag\Providers\ModuleServiceProvider::class,
        \LeadBrowser\UI\Providers\ModuleServiceProvider::class,
        \LeadBrowser\User\Providers\ModuleServiceProvider::class,
        \LeadBrowser\Workflow\Providers\ModuleServiceProvider::class,
    ],
    'register_route_models' => true
];
