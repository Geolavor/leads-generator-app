<?php

namespace LeadBrowser\Sales\Repositories;

use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\OrderAddress;

/**
 * Order Address Repository
 *
 * @author    Mariusz Malek <mariusz@leadbrowser.co>
 * @copyright 2018 LeadBrowser Software Pvt Ltd (http://www.leadbrowser.co)
 */
class OrderAddressRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

    function model()
    {
        return OrderAddress::class;
    }
}