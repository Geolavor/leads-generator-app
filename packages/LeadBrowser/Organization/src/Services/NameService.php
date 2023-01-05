<?php

namespace LeadBrowser\Organization\Services;

use LeadBrowser\Organization\Models\Name;

class NameServices
{
    /**
     * @param string $email
     * 
     * @return bool
     */
    protected function cleanName(string $email): bool
    {
        $prefix = explode('@', $email)[0];
        $words = str_contains($prefix, '.') ? explode('.', $prefix) : [$prefix];

        return Name::whereIn('name', $words)->exists() || strlen(reset($words)) <= 2;
    }
}