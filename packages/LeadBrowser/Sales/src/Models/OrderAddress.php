<?php

namespace LeadBrowser\Sales\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LeadBrowser\Sales\Database\Factories\OrderAddressFactory;
use LeadBrowser\Sales\Contracts\OrderAddress as OrderAddressContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderAddress
 *
 * @package LeadBrowser\Sales\Models
 *
 * @property integer $order_id
 * @property Order $order
 *
 */
class OrderAddress extends Model implements OrderAddressContract
{
    use HasFactory;

    public const ADDRESS_TYPE_BILLING = 'order_billing';

    /**
     * @var array default values
     */
    protected $attributes = [
        'address_type' => self::ADDRESS_TYPE_BILLING,
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        static::addGlobalScope('address_type', function (Builder $builder) {
            $builder->whereIn('address_type', [
                self::ADDRESS_TYPE_BILLING
            ]);
        });


        parent::boot();
    }

    /**
     * Get the order record associated with the address.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return OrderAddressFactory::new();
    }
}