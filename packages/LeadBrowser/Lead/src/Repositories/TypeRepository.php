<?php

namespace LeadBrowser\Lead\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class TypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Lead\Contracts\Type';
    }
}