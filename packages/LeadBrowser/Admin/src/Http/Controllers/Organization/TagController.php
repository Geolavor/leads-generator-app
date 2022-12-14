<?php

namespace LeadBrowser\Admin\Http\Controllers\Organization;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Organization\Repositories\OrganizationRepository;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Organization\Models\Organization;

class TagController extends Controller
{
    /**
     * OrganizationRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\OrganizationRepository
     */
    protected $organizationRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Organization\Repositories\OrganizationRepository  $organizationRepository
     *
     * @return void
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        Event::dispatch('organization.tag.create.before', $id);

        // $organization = $this->organizationRepository->find($id);
        $organization = Organization::findOrFail($id);

        if (! $organization->tags->contains(request('id'))) {
            $organization->tags()->attach(request('id'));
        }

        Event::dispatch('organization.tag.create.after', $organization);
        
        return response()->json([
            'status'  => true,
            'message' => trans('admin::app.organization.tag-create-success'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $organizationId
     * @param  integer  $tagId
     * @return \Illuminate\Http\Response
     */
    public function delete($organizationId)
    {
        Event::dispatch('organization.tag.delete.before', $organizationId);

        // $organization = $this->organizationRepository->find($organizationId);
        $organization = Organization::findOrFail($organizationId);

        $organization->tags()->detach(request('tag_id'));

        Event::dispatch('organization.tag.delete.after', $organization);
        
        return response()->json([
            'status'  => true,
            'message' => trans('admin::app.organization.tag-destroy-success'),
        ], 200);
    }
}