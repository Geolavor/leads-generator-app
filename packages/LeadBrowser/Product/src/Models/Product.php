<?php

namespace LeadBrowser\Product\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Product\Contracts\Product as ProductContract;

class Product extends Model implements ProductContract
{
    use CustomAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'quantity',
        'price',
        'user_id'
    ];
}
