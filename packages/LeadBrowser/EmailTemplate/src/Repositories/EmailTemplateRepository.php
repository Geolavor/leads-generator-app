<?php

namespace LeadBrowser\EmailTemplate\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class EmailTemplateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\EmailTemplate\Contracts\EmailTemplate';
    }
}