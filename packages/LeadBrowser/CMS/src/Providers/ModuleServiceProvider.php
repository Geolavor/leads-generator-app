<?php

namespace LeadBrowser\CMS\Providers;

use LeadBrowser\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \LeadBrowser\CMS\Models\CmsPage::class,
        \LeadBrowser\CMS\Models\CmsPageTranslation::class,
        \LeadBrowser\CMS\Models\CmsBlog::class,
        \LeadBrowser\CMS\Models\CmsBlogTranslation::class
    ];
}