<?php

namespace LeadBrowser\Attribute\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Attribute\Models\Attribute::class,
        \LeadBrowser\Attribute\Models\AttributeOption::class,
        \LeadBrowser\Attribute\Models\AttributeValue::class,
    ];
}