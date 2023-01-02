<?php

namespace LeadBrowser\Quote\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Quote\Models\Quote::class,
        \LeadBrowser\Quote\Models\QuoteItem::class,
    ];
}