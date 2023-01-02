<?php

namespace LeadBrowser\Result\Observers;

use LeadBrowser\Result\Events\ResultCreated;
use LeadBrowser\Result\Models\Result;
use Illuminate\Support\Facades\DB;

class ResultObserver
{
    public function creating(Result $result)
    {
        $result->stage_id = 1;
    }

    /**
     * Handle the Result "created" result.
     *
     * @param  Result\Models\Result  $result
     * @return void
     */
    public function created(Result $result)
    {
    }

    /**
     * Handle the odel "updating" result.
     *
     * @param  \Result\Models\Result  $result
     * @return void
     */
    public function updating(Result $result)
    {

    }

    /**
     * Handle the Result "updated" result.
     *
     * @param  Result\Models\Result  $result
     * @return void
     */
    public function updated(Result $result)
    {
    }

    /**
     * Handle the Result "deleting" result.
     *
     * @param  Result\Models\Result  $result
     * @return void
     */
    public function deleting(Result $result)
    {

    }
    
    /**
     * Handle the Model "restored" result.
     *
     * @param  \User\Models\User  $user
     * @return void
     */
    public function restored()
    {
        //
    }

    /**
     * Handle the Model "force deleted" result.
     *
     * @param  \User\Models\User  $user
     * @return void
     */
    public function forceDeleted()
    {
        //
    }
}
