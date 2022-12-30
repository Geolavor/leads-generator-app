<?php

namespace LeadBrowser\Result\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Result\Models\Result::class,
    ];
}