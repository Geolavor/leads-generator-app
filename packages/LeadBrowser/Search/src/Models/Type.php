<?php

namespace LeadBrowser\Search\Models;

use LeadBrowser\Search\Models\Type as ModelsType;
use Illuminate\Database\Eloquent\Model;
use LeadBrowser\Search\Contracts\Type as TypeContract;
use LeadBrowser\Search\Scope\TypeParentScope;

class Type extends Model //implements TypeContract
{
    protected $table = 'search_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'rate'
    ];

    /**
     * Get the search.
     */
    public function search()
    {
        return $this->hasMany(SearchProxy::modelClass());
    }
    
    public function subcategory()
    {
        return $this->hasMany(ModelsType::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ModelsType::class, 'parent_id');
    }
}
