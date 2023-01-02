<?php

namespace LeadBrowser\CMS\Repositories;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\CMS\Models\CmsBlogTranslationProxy;

class CmsBlogsRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        // TODO
        return 'LeadBrowser\CMS\Models\CmsBlog';
        // return 'LeadBrowser\CMS\Contracts\CmsBlog';
    }

    /**
     * @param  array  $data
     * @return \LeadBrowser\CMS\Contracts\CmsBlog
     */
    public function create(array $data)
    {
        Event::dispatch('cms.blogs.create.before');

        $model = $this->getModel();

        foreach (core()->getAllLocales() as $locale) {
            foreach ($model->translatedAttributes as $attribute) {
                if (isset($data[$attribute])) {
                    $data[$locale->code][$attribute] = $data[$attribute];
                }
            }

            $data[$locale->code]['html_content'] = str_replace('=&gt;', '=>', $data[$locale->code]['html_content']);
        }

        $blog = parent::create($data);

        Event::dispatch('cms.blogs.create.after', $blog);

        return $blog;
    }

    /**
     * @param  array  $data
     * @param  int  $id
     * @param  string  $attribute
     * @return \LeadBrowser\CMS\Contracts\CmsBloglar
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $blog = $this->find($id);

        Event::dispatch('cms.blogs.update.before', $id);

        $locale = isset($data['locale']) ? $data['locale'] : app()->getLocale();

        $data[$locale]['html_content'] = str_replace('=&gt;', '=>', $data[$locale]['html_content']);

        parent::update($data, $id, $attribute);

        Event::dispatch('cms.blogs.update.after', $id);

        return $blog;
    }

    /**
     * Checks slug is unique or not based on locale
     *
     * @param  int  $id
     * @param  string  $urlKey
     * @return bool
     */
    public function isUrlKeyUnique($id, $urlKey)
    {
        $exists = CmsBlogTranslationProxy::modelClass()::where('cms_blog_id', '<>', $id)
            ->where('url_key', $urlKey)
            ->limit(1)
            ->select(\DB::raw(1))
            ->exists();

        return $exists ? false : true;
    }

    /**
     * Retrive category from slug
     *
     * @param  string  $urlKey
     * @return \LeadBrowser\CMS\Contracts\CmsBlog|\Exception
     */
    public function findByUrlKeyOrFail($urlKey)
    {
        $blog = $this->model->whereTranslation('url_key', $urlKey)->first();

        if ($blog) {
            return $blog;
        }

        throw (new ModelNotFoundException)->setModel(
            get_class($this->model), $urlKey
        );
    }
}