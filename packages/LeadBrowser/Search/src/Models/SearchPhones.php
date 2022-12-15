<?php

namespace LeadBrowser\Search\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Organization\Models\PersonProxy;
use LeadBrowser\Core\Models\State;
use LeadBrowser\Core\Models\City;
use LeadBrowser\Core\Models\Country;
use LeadBrowser\Core\Models\PopulationProxy;
use LeadBrowser\Search\Contracts\SearchWebsites as SearchContract;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\User\Models\UserProxy;

class SearchPhones extends Model implements SearchContract
{
    use CustomAttribute;

    protected $table = 'search_phones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'urls',
        'user_id',
        'has_items',
        'status_id',
        'csv_filename',
        'csv_header',
        'csv_data'
    ];

    protected $appends = [
        'results_total_price'
    ];

    /**
     * Get the user that owns the lead.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the person that owns the lead.
     */
    public function person()
    {
        return $this->belongsTo(PersonProxy::modelClass());
    }

    /**
     * Get the results.
     */
    // public function results()
    // {
    //     return $this->hasMany(Result::class, 'search_id', 'id');
    // }
    public function results()
    {
        return $this->morphMany(Result::class, 'searchable');
    }

    public function getResultsTotalPriceAttribute()
    {
        return $this->results->sum(function($result) {
            return $result->price;
        });
    }

    public function getWebsitesAttribute()
    {
        return explode(',', $this->urls);
    }

    public function getPageStatusAttribute()
    {
        if($this->expected_items > $this->has_items) {
            return 'is_more';
        }

        if($this->next_page_token) {
            return 'is_more';
        }

        return 'finished';
    }
}
