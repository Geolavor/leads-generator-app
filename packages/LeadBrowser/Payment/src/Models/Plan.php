<?php

namespace LeadBrowser\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    /**
     * The yearly instance price.
     *
     * @var float
     */
    protected $yearlyPrice = 0.00;

    protected $fillable = [
        'name',
        'slug',
        'stripe_plan',
        'description',
        'price',
        'value',
        'currency',
        'active',
        'features'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}