<?php

namespace LeadBrowser\Organization\Models;

use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Organization\Contracts\Name as NameContract;
use Illuminate\Database\Eloquent\Model;

class Name extends Model implements NameContract
{
    protected $table = 'names';

    protected $fillable = [
        'id', 'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected $sortable = [
        'id', 'name', 'created_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
}
