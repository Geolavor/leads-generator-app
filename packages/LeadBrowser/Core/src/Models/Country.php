<?php

namespace LeadBrowser\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Core\Contracts\Country as CountryContract;

class Country extends Model implements CountryContract
{
    public $timestamps = false;

    /**
     * Get the states.
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }
}