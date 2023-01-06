<?php

namespace LeadBrowser\API\Http\Controllers\V1\Organization;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Repositories\OrganizationRepository;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Organization\OrganizationResource;

class OrganizationController extends Controller
{
    /**
     * Organization repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\OrganizationRepository
     */
    protected $organizationRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Organization\Repositories\OrganizationRepository  $organizationRepository
     * @return void
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;

        $this->addEntityTypeInRequest('organizations');
    }

    /**
     * Display a listing of the organizations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = $this->allResources($this->organizationRepository);

        return OrganizationResource::collection($organizations);
    }

    /**
     * Show resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $resource = $this->organizationRepository->find($id);

        return new OrganizationResource($resource);
    }

    /**
     * Store a newly created organization in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('organization.create.before');

        $organization = $this->organizationRepository->create($request->all());

        Event::dispatch('organization.create.after', $organization);

        return response([
            'data'    => new OrganizationResource($organization),
            'message' => __('admin::app.organizations.create-success'),
        ]);
    }

    /**
     * Update the organization in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeForm $request, $id)
    {
        Event::dispatch('organization.update.before', $id);

        $organization = $this->organizationRepository->update($request->all(), $id);

        Event::dispatch('organization.update.after', $organization);

        return response([
            'data'    => new OrganizationResource($organization),
            'message' => __('admin::app.organizations.update-success'),
        ]);
    }

    /**
     * Remove the organization from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Event::dispatch('contact.organization.delete.before', $id);

            $this->organizationRepository->delete($id);

            Event::dispatch('contact.organization.delete.after', $id);

            return response([
                'message' => __('admin::app.response.destroy-success', ['name' => __('admin::app.organizations.organization')]),
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => __('admin::app.response.destroy-failed', ['name' => __('admin::app.organizations.organization')]),
            ], 500);
        }
    }

    /**
     * Mass delete the organizations.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $organizationId) {
            Event::dispatch('contact.organization.delete.before', $organizationId);

            $this->organizationRepository->delete($organizationId);

            Event::dispatch('contact.organization.delete.after', $organizationId);
        }

        return response([
            'message' => __('admin::app.response.destroy-success', ['name' => __('admin::app.organizations.name')]),
        ]);
    }
}
