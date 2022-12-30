<?php

namespace LeadBrowser\EmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\EmailTemplate\Contracts\EmailTemplate as EmailTemplateContract;

class EmailTemplate extends Model implements EmailTemplateContract
{
    protected $fillable = [
        'name',
        'subject',
        'content',
    ];
}