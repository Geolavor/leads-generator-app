<?php

namespace LeadBrowser\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use LeadBrowser\CMS\Contracts\CmsBlogTranslation as CmsBlogTranslationContract;

class CmsBlogTranslation extends Model implements CmsBlogTranslationContract
{
    public $timestamps = false;

    protected $fillable = [
        'blog_title',
        'url_key',
        'html_content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'locale',
        'cms_page_id',
    ];
}