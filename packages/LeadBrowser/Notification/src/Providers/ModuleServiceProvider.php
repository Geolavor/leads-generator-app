<?php

namespace LeadBrowser\Notification\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Notification\Models\Notification::class
    ];
}