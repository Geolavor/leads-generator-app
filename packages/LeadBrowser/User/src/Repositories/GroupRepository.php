<?php

namespace LeadBrowser\User\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class GroupRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\User\Contracts\Group';
    }
}