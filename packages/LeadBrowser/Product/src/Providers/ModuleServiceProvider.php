<?php

namespace LeadBrowser\Product\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Product\Models\Product::class,
    ];
}