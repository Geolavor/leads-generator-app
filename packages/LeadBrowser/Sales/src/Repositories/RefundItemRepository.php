<?php

namespace LeadBrowser\Sales\Repositories;

use Illuminate\Container\Container as App;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\RefundItem;

class RefundItemRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return RefundItem::class;
    }

}