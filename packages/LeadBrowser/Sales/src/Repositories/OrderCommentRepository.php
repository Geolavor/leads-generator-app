<?php

namespace LeadBrowser\Sales\Repositories;

use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\OrderComment;

class OrderCommentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderComment::class;
    }
}
