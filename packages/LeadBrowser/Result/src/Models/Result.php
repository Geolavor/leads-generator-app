<?php

namespace LeadBrowser\Result\Models;

use LeadBrowser\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Result\Events\ResultCreated;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\Result\Events\ResultDeleted;
use LeadBrowser\Result\Events\ResultUpdated;
use LeadBrowser\User\Models\UserProxy;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'id', 'user_id', 'searchable_id', 'searchable_type', 'organization_id', 'price', 'is_payable', 'stage_id', 'is_like'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ResultCreated::class,
        'updated' => ResultUpdated::class,
        'deleted' => ResultDeleted::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user that owns the lead.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * 
     */
    public function searchable()
    {
        return $this->morphTo();
    }

    /**
     * 
     */
    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
}
