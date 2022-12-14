<?php

namespace LeadBrowser\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Core\Contracts\BlackList as BlackListContract;

class BlackList extends Model implements BlackListContract
{
    protected $table = 'black_list';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the populations.
     */
    public function populations()
    {
        return $this->hasMany(BlackListProxy::modelClass());
    }
}
