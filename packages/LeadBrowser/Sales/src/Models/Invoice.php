<?php

namespace LeadBrowser\Sales\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LeadBrowser\Sales\Contracts\Invoice as InvoiceContract;
use LeadBrowser\Sales\Traits\PaymentTerm;
use LeadBrowser\Sales\Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LeadBrowser\Sales\Traits\InvoiceReminder;
use LeadBrowser\Sales\Models\InvoiceItem;
use LeadBrowser\Sales\Models\Order;

class Invoice extends Model implements InvoiceContract
{
    use PaymentTerm, InvoiceReminder, HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Invoice status.
     *
     * @var array
     */
    protected $statusLabel = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'refunded' => 'Refunded',
    ];

    /**
     * Returns the status label from status code.
     */
    public function getStatusLabelAttribute()
    {
        return $this->statusLabel[$this->state] ?? '';
    }

    /**
     * Get the order that belongs to the invoice.
     */
    public function order(): BelongsTo
    {
        // TODO
        // return $this->belongsTo(OrderProxy::modelClass());
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the invoice items record associated with the invoice.
     */
    public function items(): HasMany
    {
        // TODO
        // return $this->hasMany(InvoiceItemProxy::modelClass())->whereNull('parent_id');
        return $this->hasMany(InvoiceItem::class)->whereNull('parent_id');
    }

    /**
     * Get the customer record associated with the invoice.
     */
    public function customer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the channel record associated with the invoice.
     */
    public function channel(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the address for the invoice.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(OrderAddressProxy::modelClass(), 'order_address_id')
                    ->where('address_type', OrderAddress::ADDRESS_TYPE_BILLING);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return InvoiceFactory::new();
    }
}
