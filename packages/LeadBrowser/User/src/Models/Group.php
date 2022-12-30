<?php

namespace LeadBrowser\User\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\User\Contracts\Group as GroupContract;

class Group extends Model implements GroupContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The users that belong to the group.
     */
    public function users()
    {
        return $this->belongsToMany(UserProxy::modelClass(), 'user_groups');
    }
}
