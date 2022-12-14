<?php

namespace LeadBrowser\Lead\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Lead\Models\Lead::class,
        \LeadBrowser\Lead\Models\Pipeline::class,
        \LeadBrowser\Lead\Models\Product::class,
        \LeadBrowser\Lead\Models\Source::class,
        \LeadBrowser\Lead\Models\Stage::class,
        \LeadBrowser\Lead\Models\Type::class,
    ];
}