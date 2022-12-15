<?php

namespace LeadBrowser\Organization\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Organization\Contracts\Organization as ContractsOrganization;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Tag\Models\TagProxy;

class Organization extends Model implements ContractsOrganization
{
    use CustomAttribute;

    protected $table = 'organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'number',
        'slug',
        'rating',
        'website',
        'country',
        'state',
        'city',
        'street',
        'street_number',
        'postal_code',
        'icon',
        'formatted_phone_number',
        'international_phone_number',
        'formatted_address',
        'lat',
        'lng',
        'keywords',
        'description',
        'is_ecommerce',
        'types',
        'in_black_list',
        'content',
        'price',
        'is_sponsored',
        'crawled_at',
        'year_founded',
        'size_range',
        'current_employee_number',
        'address'
    ];

    /**
     * The casts
     */
    protected $casts = [
        'address' => 'array',
        'crawled_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['count_emails', 'count_taxs'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function results()
    {
    	return $this->hasMany(Result::class);
    }

    public function emails()
    {
    	return $this->hasMany(Email::class);
    }

    public function taxs()
    {
    	return $this->hasMany(Tax::class);
    }

    public function socials()
    {
    	return $this->hasMany(Social::class);
    }

    public function reviews()
    {
    	return $this->hasMany(Review::class);
    }

    /**
     * Get the persons.
     */
    public function persons()
    {
        return $this->hasMany(PersonProxy::modelClass());
    }

    /**
     * The tags that belong to the lead.
     */
    public function tags()
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'organization_tags', 'organization_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // public function getWebsiteAttribute()
    // {
    //     $url = $this->website;
    //     $parse = parse_url($this->website);

    //     if (!$parse['scheme']) {
    //         $url = 'https'
    //     }
    // }

    public function scopeOpenResult()
    {
        $user_id = auth()->guard('user')->user()->id;
        
        return $this->where(function($query) use ($user_id) {
            $query->doesntHave('results')->orWhereHas('results', function($query) use ($user_id) {
                $query->where('user_id', '!=', $user_id);
            });
        });
    }

    public function scopeNotCrawledHasWebsite()
    {
        return $this->where('website', '!=', '')->whereNull('crawled_at');
    }

    public function scopeNotLinkedinHasWebsite()
    {
        return $this->where('website', '!=', '')->whereNull('linkedin_at');
    }

    /**
     * @param string $city_name
     * @param array $types
     */
    // public function scopeCityWithTypes(string $city_name, array $types)
    // {
    //     return $this
    //     ->where('city', $city_name)
    //     ->where(function($q) use ($types) {
    //         foreach ($types as $type) {
    //             $q->orWhere('types', 'LIKE', '%' . $type->name . '%');
    //         }
    //     });
    // }

    public function scopeHasWebsite()
    {
        return $this->where('website', '!=', null);
    }

    public function scopeNotWebsite()
    {
        return $this->where('website', null);
    }

    public function scopeNotCrawled()
    {
        return $this->where('crawled_at', null);
    }
    
    public function scopeCrawled()
    {
        return $this->where('crawled_at', '!=', null);
    }

    /**
     * Function showing time to search data for this organization
     */
    public function getCalculatedTimeAttribute()
    {
        $t1 = Carbon::parse($this->created_ad);
        $t2 = Carbon::parse($this->updated_at);

        return $t1->diff($t2);
    }

    public function getPreparedCountWorkersAttribute()
    {
        $persons = $this->persons()->count();

        $text = '+' . $persons;

        return $persons ? "<span class='badge badge-primary'><small>" . $text . "</small></span>" : null;
    }


    public function getCountWorkersAttribute()
    {
        return $this->persons()->count();
    }

    public function getPreparedCountEmailsAttribute()
    {
        $email = $this->emails()->where('role', '=', '')->first();

        $text = '+' . $this->count_emails;

        return $email ? "<span class='badge badge-primary'><small>" . $text . "</small></span>" : null;
    }

    public function getCountEmailsAttribute()
    {
        return $this->emails()->where('role', '=', '')->count();
    }

    public function getCountTaxsAttribute()
    {
        return $this->taxs()->count();
    }

    public function getCountSocialsAttribute()
    {
        return $this->socials()->count();
    }
    
    public function getUniqueId(): string
    {
        return (string)$this->getKey();
    }
}
