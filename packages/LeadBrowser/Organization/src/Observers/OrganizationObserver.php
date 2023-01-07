<?php

namespace LeadBrowser\Organization\Observers;

use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\User\Models\User;

class OrganizationObserver
{
    public function creating(Organization $organization)
    {

    }

    /**
     * Handle the Organization "created" organization.
     *
     * @param  Organization\Models\Organization  $organization
     * @return void
     */
    public function created(Organization $organization)
    {
        
    }

    /**
     * Handle the odel "updating" organization.
     *
     * @param  \Organization\Models\Organization  $organization
     * @return void
     */
    public function updating(Organization $organization)
    {
        // Update status?
    }

    /**
     * Handle the Organization "updated" organization.
     *
     * @param  Organization\Models\Organization  $organization
     * @return void
     */
    public function updated(Organization $organization)
    {

    }

    /**
     * Handle the Organization "deleting" organization.
     *
     * @param  Organization\Models\Organization  $organization
     * @return void
     */
    public function deleting(Organization $organization)
    {
        $organization->results()->delete();
        $organization->emails()->delete();
    }
    
    /**
     * Handle the Model "restored" organization.
     *
     * @param  \User\Models\User  $user
     * @return void
     */
    public function restored()
    {
        //
    }

    /**
     * Handle the Model "force deleted" organization.
     *
     * @param  \User\Models\User  $user
     * @return void
     */
    public function forceDeleted()
    {
        //
    }
}
