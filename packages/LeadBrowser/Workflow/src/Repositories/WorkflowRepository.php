<?php

namespace LeadBrowser\Workflow\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class WorkflowRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Workflow\Contracts\Workflow';
    }
}