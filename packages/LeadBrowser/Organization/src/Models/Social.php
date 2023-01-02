<?php

namespace LeadBrowser\Organization\Models;

use LeadBrowser\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'socials';

    protected $fillable = [
        'id', 'number', 'organization_id', 'url', 'type', 'validation', 'status'
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
