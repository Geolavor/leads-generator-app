<?php

namespace LeadBrowser\Workflow\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Workflow\Models\Workflow::class,
    ];
}