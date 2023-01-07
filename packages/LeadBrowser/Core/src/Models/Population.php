<?php

namespace LeadBrowser\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Core\Contracts\Population as PopulationContract;

class Population extends Model implements PopulationContract
{
    protected $table = 'population_sources';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number'
    ];

    /**
     * Get the populations.
     */
    public function populations()
    {
        return $this->hasMany(PopulationProxy::modelClass());
    }
}
