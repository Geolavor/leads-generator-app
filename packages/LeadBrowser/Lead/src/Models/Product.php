<?php

namespace LeadBrowser\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Product\Models\ProductProxy;
use LeadBrowser\Lead\Contracts\Product as ProductContract;
use LeadBrowser\User\Models\UserProxy;

class Product extends Model implements ProductContract
{
    protected $table = 'lead_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'price',
        'amount',
        'product_id',
        'lead_id',
        'user_id'
    ];

    /**
     * Get the product owns the lead product.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    /**
     * Get the lead that owns the lead product.
     */
    public function lead()
    {
        return $this->belongsTo(LeadProxy::modelClass());
    }

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the customer full name.
     */
    public function getNameAttribute()
    {
        return $this->product->name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $array['name'] = $this->name;

        return $array;
    }
}
