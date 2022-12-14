<?php

namespace LeadBrowser\User\Models;

use Carbon\Carbon;
use DateTime;
use LeadBrowser\CMS\Models\CmsBlog;
use LeadBrowser\Payment\Models\Usage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use LeadBrowser\User\Contracts\User as UserContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

use function Illuminate\Events\queueable;

class User extends Authenticatable implements UserContract, MustVerifyEmail
{
    use Notifiable, Billable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'image',
        'password',
        'role_id',
        'status',
        'tax_number',
        'phone',
        'allow_marketing',
        'line1',
        'line2',
        'city',
        'state',
        'country',
        'postal_code',
        'email_verified_at',
        'bonus_coin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'subscriptions'
    ];

    protected $appends = [
        'usage'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at'     => 'datetime'
    ];

    /**
     * Get image url for the product image.
     */
    public function image_url()
    {
        return $this->image ? Storage::url($this->image) : asset('vendor/leadBrowser/admin/assets/images/noavatar.png');
    }

    /**
     * Get image url for the product image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_url();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $array['image_url'] = $this->image_url;

        return $array;
    }

    public function lineOne(): ?string
    {
        return $this->line1;
    }

    public function lineTwo(): ?string
    {
        return $this->line2;
    }

    public function city(): ?string
    {
        return $this->city;
    }

    public function state(): ?string
    {
        return $this->state;
    }

    public function country(): ?string
    {
        return $this->country;
    }

    public function postalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * Get the Stripe supported currency used by the entity.
     *
     * @return string
     */
    public function getCurrency()
    {
        return 'usd';
    }

    /**
     * Get the locale for the currency used by the entity.
     *
     * @return string
     */
    public function getCurrencyLocale()
    {
        return 'en_USD';
    }


    /**
     * Add the currency symbol to a given amount.
     *
     * @param  string  $amount
     * @return string
     */
    public function addCurrencySymbol($amount)
    {
        return '$'.$amount;
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(RoleProxy::modelClass());
    }

    /**
     * The groups that belong to the user.
     */
    public function groups()
    {
        return $this->belongsToMany(GroupProxy::modelClass(), 'user_groups');
    }

    /**
     * Get the blog posts
     */
    public function posts()
    {
        return $this->hasMany(CmsBlog::class, 'user_id', 'id');
    }

    /**
     * 
     */
    public function getSubscriptionAttribute()
    {
        return $this->subscriptions()->active()->first();
    }

    public function getUsagesAttribute()
    {
        // return Usage::where('subscription_id', $this->subscription['id'])->first();
    }

    /**
     * 
     */
    public function getUsageAttribute()
    {
        $days = null;
        $usage = null;

        if($this->subscription) {

            $usage = Usage::where('subscription_id', $this->subscription['id'])->first();

            $fdate = $this->subscription['updated_at'];
            $tdate = Carbon::parse($fdate)->addMonth()->format('Y-m-d');

            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            
            $days = $interval->format('%a');

            if($usage) {
                $percentage = $usage->used / $usage->limit * 100;
            }
        }

        return [
            'days'       => $days ?? 0,
            'available'  => $this->bonus_coin != 0 ? $this->bonus_coin : ($usage ? $usage->limit : 0),
            'used'       => $usage ? $usage->used : 0,
            'percentage' => $usage ? $percentage : 0
        ];
    }

    /**
     * 
     */
    public function getMonthlySubscriptionExpiredAttribute()
    {
        if ($this->userSubscription) {
            if ($this->userSubscription->plan->name === 'Free' || $this->userSubscription->userSubscription_expiry_date <= Carbon::now()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if user has permission to perform certain action.
     *
     * @param  string  $permission
     * @return boolean
     */
    public function hasPermission($permission)
    {
        if ($this->role->permission_type == 'custom' && ! $this->role->permissions) {
            return false;
        }

        return in_array($permission, $this->role->permissions);
    }

    public function stripeAddress()
    {
        return [
            'line1'         => $this->lineOne(),
            'line2'         => $this->lineTwo(),
            'city'          => $this->city(),
            'state'         => $this->state(),
            'country'       => $this->country(),
            'postal_code'   => $this->postalCode(),
        ];
    }
}