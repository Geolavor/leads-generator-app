<?php

namespace LeadBrowser\Sales\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\InvoiceItem;

class InvoiceItemRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return InvoiceItem::class;
    }
}