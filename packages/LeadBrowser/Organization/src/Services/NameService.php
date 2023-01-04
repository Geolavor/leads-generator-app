<?php

namespace LeadBrowser\Organization\Services;

class NameServices
{
    /**
     * @param string $email
     * 
     * @return bool
     */
    protected function cleanName(string $email): bool
    {
        $result = false;

        $email = explode('@', $email);
        $prefix = $email[0];

        /**
         * If dot (.) exist in prefix
         */
        $words = str_contains($prefix, '.') ? explode('.', $prefix) : [$prefix];

        foreach ($words as $key => $word) {
            $exist = Name::where('name', $word)->first();
            if ($exist) return true;
        }

        return $result;
    }
}