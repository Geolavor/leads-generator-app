<?php

namespace LeadBrowser\Core\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class PopulationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Core\Contracts\Population';
    }
}