<?php

namespace LeadBrowser\Payment\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class PlanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Payment\Models\Plan';
    }
}