<?php

namespace LeadBrowser\Tag\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\User\Models\UserProxy;
use LeadBrowser\Tag\Contracts\Tag as TagContract;

class Tag extends Model implements TagContract
{
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];

    /**
     * Get the user that owns the tag.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }
}
