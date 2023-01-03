<?php

namespace LeadBrowser\Admin\Http\Controllers\Organization;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Models\Employee;
use LeadBrowser\Organization\Repositories\EmployeeRepository;
use LeadBrowser\Organization\Models\Email;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Organization\Repositories\OrganizationRepository;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Result\Services\ResultService;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\UI\Export\OrganizationsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * OrganizationRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\OrganizationRepository
     */
    protected $organizationRepository;

    /**
     * Employee repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Organization\Repositories\OrganizationRepository  $organizationRepository
     * @param \LeadBrowser\Product\Repositories\OrganizationRepository  $organizationRepository
     * @param \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * 
     * @return void
     */
    public function __construct(
        OrganizationRepository $organizationRepository,
        EmployeeRepository $employeeRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationRepository = $organizationRepository;
        $this->employeeRepository = $employeeRepository;

        request()->request->add(['entity_type' => 'organizations']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Organization\OrganizationDataGrid::class)->toJson();
        }

        return view('admin::organizations.index');
    }

    /**
     * Display a resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // $organization = $this->organizationRepository->findOrFail($id);
        $organization = Organization::select(
            'id', 'icon', 'title', 'description',
            'types', 'country', 'city', 'website', 'archive',
            'international_phone_number', 'size_range', 'year_founded'
        )->with(['employees'])->findOrFail($id);

        $similars = DB::table('organizations')
        ->addSelect(
            'organizations.id',
            'organizations.icon',
            'organizations.title',
            'organizations.description',
            'organizations.types',
            'organizations.website',
            'organizations.country',
            'organizations.city',
            'organizations.is_ecommerce',
            'organizations.is_sponsored',
            'organizations.keywords'
        )
        ->where('id', '!=', $organization->id)
        ->where('country', $organization->country)
        ->where('types', $organization->types)
        ->where('crawled_at', '!=', null)
        ->limit(10)
        ->get()
        ->all();

        return view('admin::organizations.view', compact('organization', 'similars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('organization.create.before');

        $data = request()->all();

        $organization = $this->organizationRepository->create($data);

        Event::dispatch('organization.create.after', $organization);

        session()->flash('success', trans('admin::app.organizations.create-success'));

        return redirect()->route('organizations.index');
    }

    /**
     * Function for buy one organization
     *
     * @return \Illuminate\View\View
     */
    public function buy()
    {
        $organization = Organization::findOrFail(request('organization_id'));

        $currentUser = auth()->guard('user')->user();
        $usage = $currentUser->usage;

        /**
         * If user dosen't have enough coins in wallet
         */
        if(($currentUser->bonus_coin > 0) && $currentUser->bonus_coin < 1 || ($usage['available'] - $usage['used']) < 1) {
            session()->flash('warning', trans('admin::app.search.you-dont-have-enough-coins'));
            return redirect()->back();
        }

        $result = Result::where('organization_id', $organization->id)->where('user_id', $currentUser->id)->first();
        if ($result) {
            session()->flash('warning', trans('admin::app.search.you-have-already-this-co'));
            return redirect()->back();
        }

        ResultService::createResult(
            'LeadBrowser\Search\Models\SearchLocations',
            0,
            $currentUser->id,
            null,
            $organization->id,
            $organization->content
        );

        session()->flash('success', trans('admin::app.organizations.update-success'));

        return redirect()->route('organizations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // $organization = $this->organizationRepository->findOrFail($id);
        $organization = Organization::findOrFail($id);

        return view('admin::organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeForm $request, $id)
    {
        Event::dispatch('organization.update.before', $id);

        $organization = $this->organizationRepository->update(request()->all(), $id);

        Event::dispatch('organization.update.after', $organization);

        session()->flash('success', trans('admin::app.organizations.update-success'));

        return redirect()->route('organizations.index');
    }

    /**
     * Export organizations
     */
    public function export()
    {
        $currentUser = auth()->guard('user')->user();
        $search = SearchLocations::where('user_id', $currentUser->id)->findOrFail(request('search_id'));

        if(!$search) {
            return;
        }

        // return (new OrganizationsExport)->download($search->name . '-' . Str::random(16) . '.xlsx');
    }

    /**
     * Search organization organizations
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $organizations = $this->organizationRepository->findWhere([
            ['title', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($organizations);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->organizationRepository->findOrFail($id);

        try {
            Event::dispatch('settings.organizations.delete.before', $id);

            $this->organizationRepository->delete($id);

            Event::dispatch('settings.organizations.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.organizations.organization')]),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.organizations.organization')]),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $organizationId) {
            Event::dispatch('organization.delete.before', $organizationId);

            $this->organizationRepository->delete($organizationId);

            Event::dispatch('organization.delete.after', $organizationId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.organizations.title')]),
        ]);
    }

    /**
     * Mass Add To Organization the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massBuy()
    {
        $currentUser = auth()->guard('user')->user();
        $usage = $currentUser->usage;

        /**
         * If user dosen't have enough coins in wallet
         */
        if(($currentUser->bonus_coin > 0) && $currentUser->bonus_coin < count(request('rows')) || ($usage['available'] - $usage['used']) < count(request('rows'))) {
            session()->flash('warning', trans('admin::app.search.you-dont-have-enough-coins'));
            return redirect()->back();
        }

        foreach (request('rows') as $organizationId) {
            Event::dispatch('organization.add.before', $organizationId);

            $organization = Organization::with(['taxs', 'socials'])->findOrFail($organizationId);

            $result = Result::where('organization_id', $organizationId)->where('user_id', $currentUser->id)->first();
            if ($result) {
                session()->flash('warning', trans('admin::app.search.you-have-already-this-co'));
                return redirect()->back();
            }

            ResultService::createResult(
                'LeadBrowser\Search\Models\SearchLocations',
                0,
                $currentUser->id,
                null,
                $organization->id,
                $organization->content
            );

            Event::dispatch('organization.add.after', $organizationId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.organizations.title')]),
        ]);
    }

    /**
     * TODO
     */
    public function transfer()
    {
        $organization = Organization::with(['taxs', 'socials'])->findOrFail(request('organization_id'));
        $emails = Email::where('organization_id', $organization->id)->get();

        /**
         * Check if company is already saved in the organization
         */
        $organization = Organization::where('user_id', auth()->guard('user')->user()->id)->where('title', $organization->title)->first();
        if($organization) {
            return redirect()->back()->with('message','You already added this company to contact!');
        }

        $organization = $this->organizationRepository->create([
            'entity_type' => 'organizations',
            'title' => $organization->title,
            'address' => $organization->country,
            'user_id' => auth()->guard('user')->user()->id
        ]);

        foreach ($emails as $key => $value) {

            $emails = [];
            $phones = [];

            $name = explode("@", $value->email);

            // $full_name = explode(".", $value->email);
            //$full_name[0] . $full_name[1],

            array_push($emails, ["label" => "work", "value" => $value->email]);
            array_push($phones, ["label" => "work", "value" => '']);

            $this->employeeRepository->create([
                'entity_type' => 'employees',
                'name' => ucfirst($name[0]),
                'emails' => $emails,
                'contact_numbers' => $phones,
                'organization_id' => $organization->id,
                'user_id' => auth()->guard('user')->user()->id
            ]);

        }

        session()->flash('success', trans('admin::app.employees.create-success'));

        return redirect()->back()->with('message','Operation Successful !');
    }
}
