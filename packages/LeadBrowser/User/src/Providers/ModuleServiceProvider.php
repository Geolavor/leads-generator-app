<?php

namespace LeadBrowser\User\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\User\Models\Group::class,
        \LeadBrowser\User\Models\Role::class,
        \LeadBrowser\User\Models\User::class,
    ];
}