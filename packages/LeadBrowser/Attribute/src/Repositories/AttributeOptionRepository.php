<?php

namespace LeadBrowser\Attribute\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class AttributeOptionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Attribute\Contracts\AttributeOption';
    }
}