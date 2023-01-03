<?php

namespace LeadBrowser\Quote\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\User\Models\UserProxy;
use LeadBrowser\Organization\Models\EmployeeProxy;
use LeadBrowser\Lead\Models\LeadProxy;
use LeadBrowser\Quote\Contracts\Quote as QuoteContract;

class Quote extends Model implements QuoteContract
{
    use CustomAttribute;

    protected $table = 'quotes';

    protected $casts = [
        'billing_address'  => 'array',
        'expired_at'       => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'description',
        'billing_address',
        'discount_percent',
        'discount_amount',
        'tax_amount',
        'adjustment_amount',
        'sub_total',
        'grand_total',
        'expired_at',
        'user_id',
        'employee_id',
    ];

    /**
     * Get the quote items record associated with the quote.
     */
    public function items()
    {
        return $this->hasMany(QuoteItemProxy::modelClass());
    }

    /**
     * Get the user that owns the quote.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the employee that owns the quote.
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeProxy::modelClass());
    }

    /**
     * The leads that belong to the quote.
     */
    public function leads()
    {
        return $this->belongsToMany(LeadProxy::modelClass(), 'lead_quotes');
    }
}
