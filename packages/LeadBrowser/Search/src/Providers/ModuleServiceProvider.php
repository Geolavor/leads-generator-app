<?php

namespace LeadBrowser\Search\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Search\Models\SearchLocations::class,
    ];
}