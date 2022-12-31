<?php

namespace LeadBrowser\Organization\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $table = 'analysis';

    protected $fillable = [
        'id', 'user_id', 'typeable_id', 'typeable_type', 'organization_id', 'stage_id'
    ];

    protected $allowedFilters = [
        'id', 'created_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function typeable()
    {
        return $this->morphTo();
    }
}
