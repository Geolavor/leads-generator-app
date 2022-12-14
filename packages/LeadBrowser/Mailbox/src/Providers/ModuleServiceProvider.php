<?php

namespace LeadBrowser\Mailbox\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Mailbox\Models\Mailbox::class,
        \LeadBrowser\Mailbox\Models\Attachment::class,
    ];
}