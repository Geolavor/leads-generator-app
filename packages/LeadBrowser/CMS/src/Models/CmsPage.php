<?php

namespace LeadBrowser\CMS\Models;

use LeadBrowser\Core\Eloquent\TranslatableModel;
use LeadBrowser\CMS\Contracts\CmsPage as CmsPageContract;

class CmsPage extends TranslatableModel implements CmsPageContract
{
    protected $fillable = ['layout'];

    public $translatedAttributes = [
        'content',
        'meta_description',
        'meta_title',
        'page_title',
        'meta_keywords',
        'html_content',
        'url_key',
    ];

    protected $with = ['translations'];
}