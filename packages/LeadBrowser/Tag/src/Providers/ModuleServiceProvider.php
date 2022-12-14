<?php

namespace LeadBrowser\Tag\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Tag\Models\Tag::class,
    ];
}