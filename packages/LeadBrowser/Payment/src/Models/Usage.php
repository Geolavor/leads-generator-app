<?php

namespace LeadBrowser\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Payment\Models\Feature;
use LeadBrowser\Payment\Models\Saas;

class Usage extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'subscription_usages';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subscription_id',
        'feature_id',
        'used',
        'limit',
    ];
}
