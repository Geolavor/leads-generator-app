<?php

namespace LeadBrowser\Organization\Models;

use LeadBrowser\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';

    protected $fillable = [
        'id', 'number', 'organization_id', 'name', 'role', 'email', 'type',
        'rfc_validation', 'no_rfc_validation', 'dns_check',
        'free_email_provider', 'disposable_email_provider',
        'role_or_business_email', 'spoof_check', 'is_correct', 'description'
    ];

    protected $casts = [
        'number' => 'string'
    ];

    protected $sortable = [
        'id', 'number', 'created_at'
    ];

    protected $searchable = [
        'number', 'emails'
    ];

    protected $allowedFilters = [
        'id', 'created_at', 'number'
    ];

    // protected $appends = [
    //     'validation'
    // ];

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

    // public function getValidationAttribute()
    // {
    //     $percent = 0;
        
    //     if($this->rfc_validation == 1) $percent = $percent + 25;
    //     if($this->rfc_warnings_validation == 1) $percent = $percent + 25;
    //     if($this->dns_validation == 1) $percent = $percent + 25;
    //     if($this->message_id_validation == 1) $percent = $percent + 25;

    //     return $percent;
    // }
}
