<?php

namespace LeadBrowser\Sales\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\Sales\Models\Order::class,
        \LeadBrowser\Sales\Models\OrderItem::class,
        \LeadBrowser\Sales\Models\DownloadableLinkPurchased::class,
        \LeadBrowser\Sales\Models\OrderAddress::class,
        \LeadBrowser\Sales\Models\OrderPayment::class,
        \LeadBrowser\Sales\Models\OrderComment::class,
        \LeadBrowser\Sales\Models\Invoice::class,
        \LeadBrowser\Sales\Models\InvoiceItem::class,
        \LeadBrowser\Sales\Models\Refund::class,
        \LeadBrowser\Sales\Models\RefundItem::class,
        \LeadBrowser\Sales\Models\OrderTransaction::class,
    ];
}