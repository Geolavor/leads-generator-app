<?php

namespace LeadBrowser\Core\Providers;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Core\Models\CoreConfig::class,
        \LeadBrowser\Core\Models\Country::class,
        \LeadBrowser\Core\Models\State::class,
        \LeadBrowser\Core\Models\City::class,
        \LeadBrowser\Core\Models\Population::class,
    ];
}