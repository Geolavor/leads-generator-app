<?php

namespace LeadBrowser\Core\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class BlackListRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Core\Models\BlackList';
    }
}