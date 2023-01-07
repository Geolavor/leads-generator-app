<?php

namespace LeadBrowser\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Core\Contracts\State as StateContract;

class State extends Model implements StateContract
{
    public $timestamps = false;

    /**
     * Get the country.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the cities.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}