<?php

namespace LeadBrowser\Core\Repositories;

use LeadBrowser\Core\Eloquent\Repository;
use Prettus\Repository\Traits\CacheableRepository;

class CityRepository extends Repository
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Core\Contracts\City';
    }
}