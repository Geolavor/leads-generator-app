<?php

namespace LeadBrowser\Sales\Repositories;

use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\OrderTransaction;

/**
 * Order Transaction Repository
 *
 * @author    Mariusz Malek <mariusz@leadbrowser.co>
 * @copyright 2018 LeadBrowser Software Pvt Ltd (http://www.leadbrowser.co)
 */
class OrderTransactionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

    function model()
    {
        return OrderTransaction::class;
    }
}