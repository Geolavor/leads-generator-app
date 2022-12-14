<?php

namespace LeadBrowser\Activity\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Activity\Models\Activity::class,
        \LeadBrowser\Activity\Models\File::class,
        \LeadBrowser\Activity\Models\Participant::class,
    ];
}