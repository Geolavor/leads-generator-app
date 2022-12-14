<?php

namespace LeadBrowser\Activity\Repositories;

use LeadBrowser\Core\Eloquent\Repository;

class ParticipantRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Activity\Contracts\Participant';
    }
}