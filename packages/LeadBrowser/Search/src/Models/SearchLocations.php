<?php

namespace LeadBrowser\Search\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Organization\Models\PersonProxy;
use LeadBrowser\Core\Models\State;
use LeadBrowser\Core\Models\City;
use LeadBrowser\Core\Models\Country;
use LeadBrowser\Core\Models\PopulationProxy;
use LeadBrowser\Search\Models\Type;
use LeadBrowser\Search\Contracts\SearchLocations as SearchContract;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Tag\Models\TagProxy;
use LeadBrowser\User\Models\UserProxy;
use Illuminate\Support\Facades\DB;

class SearchLocations extends Model implements SearchContract
{
    use CustomAttribute;

    protected $table = 'search_locations';

    protected $casts = [
        'location' => 'array',
        'conditions' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'location',
        'last_city_id',
        'has_items',
        'expected_items',
        'all_items',
        'next_page_token',
        'status_id',
        'total_price',
        'conditions',
        'all_country',
        'batch_id',
        'type_id'
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

    /**
     * Get the type that owns the lead.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * The tags that belong to the lead.
     */
    public function tags()
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'search_tags', 'search_id');
    }

    public function getTypesAttribute()
    {
        $subcategory = $this->type->subcategory;

        $subcategory->push($this->type);

        return $subcategory->all();
    }

    /**
     * Get types by name
     * @param string $name
     */
    public function typesByName(string $name)
    {
        return $this->type->subcategory->where('name', $name);
    }

    /**
     * Get the population.
     */
    public function population()
    {
        return $this->belongsTo(PopulationProxy::modelClass());
    }

    public function getCityAttribute()
    {
        $city = $this->location['city'] ?? false;
        return $city ? City::where('id', $this->location['city'])->first() : false;
    }

    public function getStateAttribute()
    {
        $state = $this->location['state'] ?? false;
        return $state ? State::where('country_code', $this->location['state'])->first() : false;
    }

    public function getCountryAttribute()
    {
        return Country::where('code', $this->location['country'])->first();
    }


    /**
     * Get cities relative to the state
     * and with a larger population than selected
     */
    public function getCitiesAttribute()
    {
        $cities = array();
        
        $country = $this->location['country'] ?? false;
        $state = $this->location['state'] ?? false;
        $city = $this->location['city'] ?? false;

        if($state && $country) {
            $cities = City::with('state')->where('country_code', $country)->where('state_id', $state)
            // ->where('population', $population->id == 1 ? '<=' : '>=', $population->number)
            ->get();
        } else if(!$state && $country) {
            $cities = City::with('state')->where('country_code', $country)->get();
        } else if(!$state && !$country && $city) {
            $cities = City::with('state')->findOrFail($city);
        }

        return $cities->pluck('name')->all();
    }

    /**
     * @param string $organization_id
     */
    public function organizationByPlaceId(string $organization_id)
    {
        return $this->results()->whereHas('organization', function ($query) use ($organization_id) {
            $query->where('organization_id', $organization_id);
        })->get();
    }

    public function getTimeAttribute()
    {
        $pattern = ($this->expected_items - $this->has_items) * 15;

        $time = CarbonInterval::seconds($pattern)->cascade()->forHumans();

        return $time;
    }

    public function getResultsTotalPriceAttribute()
    {
        return $this->results->sum(function($result) {
            return $result->price;
        });
    }

    /**
     * If has last_city_id then get only bigger cities. If don't have
     * last_city_id then sho all cities
     */
    public function getLocationsAttribute()
    {        
        return $this->last_city_id > 0 ? $this->cities->filter(function ($city) {
            return $city->id > $this->last_city_id;
        }) : $this->cities;
    }

    public function getLocationMapAttribute()
    {
        $cities = $this->cities->filter(function ($city) {
            return $city->id > $this->last_city_id;
        });
        
        return $cities;
    }

    /**
     * Analyze market size in location
     */
    public function getLocationMarketSizeAttribute()
    {
        return 120;

        /**
         * 10 results X pagination API
         * OR
         * count similar results in our database
         */

        // $cities = $this->cities->filter(function ($city) {
        //     return $city->id > $this->last_city_id;
        // });

        // return count($cities) * 20;
    }

    public function getSearchStatusAttribute()
    {
        return $this->has_items <= $this->expected_items;
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
