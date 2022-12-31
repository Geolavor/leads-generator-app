<?php

namespace LeadBrowser\Organization\Traits;

use LeadBrowser\Organization\Models\Organization;

trait Organizationable
{
    /**
     * @param string $query
     * @param string $column
     */
    public function searchOrganizationBy(string $query = '', string $column = '')
    {
        return Organization::where($column, $query)->first();
    }

    /**
     * @param $data
     */
    public function createOrganization($data)
    {
        return Organization::create($data);
    }
}