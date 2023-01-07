<?php

namespace LeadBrowser\Core\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use LeadBrowser\Core\Models\Locale;
use LeadBrowser\Core\Helpers\Locales;

class TranslatableModel extends Model
{
    use Translatable;

    protected function getLocalesHelper(): Locales
    {
        return app(Locales::class);
    }

    /**
     * @param  string  $key
     * @return bool
     */
    protected function isKeyALocale($key)
    {
        $chunks = explode('-', $key);

        if (count($chunks) > 1) {
            if (Locale::where('code', '=', end($chunks))->first()) {
                return true;
            }
        } elseif (Locale::where('code', '=', $key)->first()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function locale()
    {
        if ($this->isChannelBased()) {
            return core()->getDefaultChannelLocaleCode();
        } else {
            if ($this->defaultLocale) {
                return $this->defaultLocale;
            }

            return config('translatable.locale') ?: app()->make('translator')->getLocale();
        }
    }

    /**
     * @return bool
     */
    protected function isChannelBased()
    {
        return false;
    }
}