<?php

namespace LeadBrowser\Organization\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Attribute\Traits\CustomAttribute;
use LeadBrowser\Organization\Contracts\Person as PersonContract;
use LeadBrowser\User\Models\UserProxy;

class Person extends Model implements PersonContract
{
    use CustomAttribute;

    protected $table = 'persons';

    protected $with = 'organization';

    protected $casts = [
        'emails'          => 'array',
        'contact_numbers' => 'array',
        'social_media'    => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'emails',
        'contact_numbers',
        'social_media',
        'organization_id',
        'role',
        'user_id'
    ];

    /**
     * Get the organization that owns the person.
     */
    public function organization()
    {
        return $this->belongsTo(OrganizationProxy::modelClass());
    }

    /**
     * Get the user that owns the person.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }
}
