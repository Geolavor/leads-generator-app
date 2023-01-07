<?php

namespace LeadBrowser\Organization\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Organization\Models\Organization::class,
        \LeadBrowser\Organization\Models\Employee::class,
    ];
}