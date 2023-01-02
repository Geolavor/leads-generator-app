<?php

namespace LeadBrowser\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Core\Contracts\City as CityContract;
use LeadBrowser\Core\Models\State;

class City extends Model implements CityContract
{
    protected $table = 'cities';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * Get the state.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}