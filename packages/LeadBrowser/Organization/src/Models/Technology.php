<?php

namespace LeadBrowser\Organization\Models;

use LeadBrowser\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $table = 'technologies';

    protected $fillable = [
        'id', 'type', 'organization_id'
    ];

    protected $casts = [
        'type' => 'string'
    ];

    protected $sortable = [
        'id', 'type', 'created_at'
    ];

    protected $allowedFilters = [
        'id', 'created_at', 'type'
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
