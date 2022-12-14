<?php

namespace LeadBrowser\Tag\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class TagRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Tag\Contracts\Tag';
    }
}