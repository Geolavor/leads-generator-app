<?php

namespace LeadBrowser\Organization\Models;

use LeadBrowser\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxs';

    protected $fillable = [
        'id', 'number', 'organization_id', 'tax'
    ];

    protected $casts = [
        'number' => 'string'
    ];

    protected $sortable = [
        'id', 'number', 'created_at'
    ];

    protected $searchable = [
        'number', 'tax'
    ];

    protected $allowedFilters = [
        'id', 'created_at', 'number'
    ];

    /**
     * This hide defined column
     */
    protected $hidden = [
        // 'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
}
