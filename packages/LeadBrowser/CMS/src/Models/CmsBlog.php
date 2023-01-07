<?php

namespace LeadBrowser\CMS\Models;

use LeadBrowser\Core\Eloquent\TranslatableModel;
use LeadBrowser\CMS\Contracts\CmsBlog as CmsBlogContract;
use LeadBrowser\User\Models\User;
use Illuminate\Support\Facades\Storage;

class CmsBlog extends TranslatableModel implements CmsBlogContract
{
    protected $fillable = ['author_id', 'layout', 'image'];

    public $translatedAttributes = [
        'content',
        'meta_description',
        'meta_title',
        'blog_title',
        'meta_keywords',
        'html_content',
        'url_key',
    ];

    protected $with = ['translations', 'author'];

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
     * Get the author
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}