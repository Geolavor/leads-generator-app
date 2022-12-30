<?php

namespace LeadBrowser\Core\Traits;

use LeadBrowser\Core\Models\BlackList;

trait BlackListTrait
{
    /**
     * @param string $email
     * @param string $website
     */
    public function validateAddress(string $email = '', string $website = null)
    {
        $black_list = $this->validateBlacklist($email);

        if(!$black_list) {
            return false;
        }
        
        if($website) {
            $gpdr = $this->validateGpdr($email, $website);

            if(!$gpdr) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $email
     */
    protected function validateBlacklist(string $email = '')
    {
        $black_list = BlackList::where('email', $email)->where('status_id', 2)->first();

        if(!$black_list) {
            return false;
        }

        return true;
    }

    /**
     * @param string $email
     * @param string $website
     */
    protected function validateGpdr(string $email, string $website)
    {
        $domain = parse_url($website);
        $host = $domain['host'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            // Separate string by @ characters (there should be only one)
            $parts = explode('@', $email);

            // Remove and return the last part, which should be the domain
            $domain = array_pop($parts);

            // Check if the domain is in our list
            if (str_contains($host, $domain)) {
                return false;
            }
        }

        return true;
    }
}