<?php

namespace LeadBrowser\EmailTemplate\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\EmailTemplate\Models\EmailTemplate::class,
    ];
}