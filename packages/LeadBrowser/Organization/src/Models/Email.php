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

        // NEW: TODO
        // "blacklisted": false,
        // "malicious_activity": false,
        // "malicious_activity_recent": false,
        // "credentials_leaked": false,
        // "credentials_leaked_recent": false,
        // "data_breach": false,
        // "first_seen": "never",
        // "last_seen": "never",
        // "domain_exists": true,
        // "domain_reputation": "low",
        // "new_domain": true,
        // "days_since_domain_creation": 54,
        // "suspicious_tld": false,
        // "spam": false,
        // "free_provider": false,
        // "disposable": false,
        // "deliverable": false,
        // "accept_all": false,
        // "valid_mx": true,
        // "primary_mx": "smtp.secureserver.net",
        // "spoofable": true,
        // "spf_strict": false,
        // "dmarc_enforced": false,
        // "profiles": [
            // "myspace",
            // "spotify",
            // "twitter",
            // "pinterest",
            // "flickr",
            // "linkedin",
            // "vimeo",
            // "angellist"
        // ]
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
