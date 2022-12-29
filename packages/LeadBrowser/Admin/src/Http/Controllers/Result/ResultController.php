<?php

namespace LeadBrowser\Admin\Http\Controllers\Result;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Organization\Models\Person;
use LeadBrowser\Organization\Repositories\OrganizationRepository;
use LeadBrowser\Organization\Repositories\PersonRepository;
use LeadBrowser\Organization\Models\Email;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Result\Repositories\ResultRepository;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\UI\Export\ResultsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ResultController extends Controller
{
    /**
     * ResultRepository object
     *
     * @var \LeadBrowser\Result\Repositories\ResultRepository
     */
    protected $resultRepository;

    /**
     * OrganizationRepository object
     *
     * @var \LeadBrowser\Product\Repositories\OrganizationRepository
     */
    protected $organizationRepository;

    /**
     * Person repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\PersonRepository
     */
    protected $personRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Result\Repositories\ResultRepository  $resultRepository
     * @param \LeadBrowser\Product\Repositories\OrganizationRepository  $organizationRepository
     * @param \LeadBrowser\Organization\Repositories\PersonRepository  $personRepository
     * 
     * @return void
     */
    public function __construct(
        ResultRepository $resultRepository,
        OrganizationRepository $organizationRepository,
        PersonRepository $personRepository)
    {
        $this->resultRepository = $resultRepository;
        $this->organizationRepository = $organizationRepository;
        $this->personRepository = $personRepository;

        request()->request->add(['entity_type' => 'results']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Result\ResultDataGrid::class)->toJson();
        }

        return view('admin::results.index');
    }

    /**
     * Display a resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // $result = $this->resultRepository->findOrFail($id);
        $result = Result::with([
            'searchable', 'organization', 'organization.taxs', 'organization.socials',
            'organization.reviews', 'organization.persons'
        ])->findOrFail($id);

        $result->archive = $result->organization->archive;

        // dd($result->archive[0]);

        $emails = Email::where('organization_id', $result->organization_id)->get();

        $currentUser = auth()->guard('user')->user();

        // TODO
        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $userIds = app('\LeadBrowser\User\Repositories\UserRepository')->getCurrentUserGroupsUserIds();

                if (!in_array($result->user_id, $userIds)) {
                    return redirect()->route('search.location.index');
                }
            } else {
                if ($result->user_id != $currentUser->id) {
                    return redirect()->route('search.location.index');
                }
            }
        }

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
        ->where('id', '!=', $result->organization->id)
        ->where('country', $result->organization->country)
        ->where('types', $result->organization->types)
        ->where('crawled_at', '!=', null)
        ->limit(10)
        ->get()
        ->all();

        return view('admin::results.view', compact('result', 'emails', 'similars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::results.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('result.create.before');

        $data = request()->all();

        $result = $this->resultRepository->create($data);

        Event::dispatch('result.create.after', $result);

        session()->flash('success', trans('admin::app.results.create-success'));

        return redirect()->route('results.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // $result = $this->resultRepository->findOrFail($id);
        $result = Result::findOrFail($id);

        return view('admin::results.edit', compact('result'));
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
        Event::dispatch('result.update.before', $id);

        $result = $this->resultRepository->update(request()->all(), $id);

        Event::dispatch('result.update.after', $result);

        session()->flash('success', trans('admin::app.results.update-success'));

        return redirect()->route('results.index');
    }

    /**
     * Search result results
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->resultRepository->findWhere([
            ['name', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->resultRepository->findOrFail($id);

        try {
            Event::dispatch('settings.results.delete.before', $id);

            $this->resultRepository->delete($id);

            Event::dispatch('settings.results.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.results.result')]),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.results.result')]),
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
        foreach (request('rows') as $resultId) {
            Event::dispatch('result.delete.before', $resultId);

            $this->resultRepository->delete($resultId);

            Event::dispatch('result.delete.after', $resultId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.results.title')]),
        ]);
    }

    /**
     * Mass Add To Organization the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massAddToOrganization()
    {
        foreach (request('rows') as $resultId) {
            Event::dispatch('result.add.before', $resultId);

            $result = Result::with(['searchable', 'organization', 'organization.taxs', 'organization.socials'])->findOrFail($resultId);
            $emails = Email::where('organization_id', $result->organization_id)->get();

            /**
             * Check if company is already saved in the organization
             */
            $organization = Organization::where('user_id', auth()->guard('user')->user()->id)->where('name', $result->organization->title)->first();
            if($organization) {
                return redirect()->back()->with('message','You already added this company to contact!');
            }

            $organization = $this->organizationRepository->create([
                'entity_type' => 'organizations',
                'name' => $result->organization->title,
                'address' => $result->organization->location,
                'user_id' => auth()->guard('user')->user()->id
            ]);
    
            foreach ($emails as $key => $value) {
    
                $emails = [];
                $phones = [];
    
                $name = explode("@", $value->email);
    
                array_push($emails, ["label" => "work", "value" => $value->email]);
                array_push($phones, ["label" => "work", "value" => '']);
    
                $this->personRepository->create([
                    'entity_type' => 'persons',
                    'name' => ucfirst($name[0]),
                    'emails' => $emails,
                    'contact_numbers' => $phones,
                    'organization_id' => $organization->id,
                    'user_id' => auth()->guard('user')->user()->id
                ]);
    
            }

            Event::dispatch('result.add.after', $resultId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.results.title')]),
        ]);
    }

    /**
     * TODO
     */
    public function transfer()
    {
        $result = Result::with(['searchable', 'organization', 'organization.taxs', 'organization.socials'])->findOrFail(request('result_id'));
        $emails = Email::where('organization_id', $result->organization_id)->get();

        /**
         * Check if company is already saved in the organization
         */
        $organization = Organization::where('user_id', auth()->guard('user')->user()->id)->where('name', $result->organization->title)->first();
        if($organization) {
            return redirect()->back()->with('message','You already added this company to contact!');
        }

        $organization = $this->organizationRepository->create([
            'entity_type' => 'organizations',
            'name' => $result->organization->title,
            'address' => $result->organization->location,
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

            $this->personRepository->create([
                'entity_type' => 'persons',
                'name' => ucfirst($name[0]),
                'emails' => $emails,
                'contact_numbers' => $phones,
                'organization_id' => $organization->id,
                'user_id' => auth()->guard('user')->user()->id
            ]);

        }

        session()->flash('success', trans('admin::app.persons.create-success'));

        return redirect()->back()->with('message','Operation Successful !');
    }

    /**
     * Export results
     */
    public function export()
    {
        $currentUser = auth()->guard('user')->user();

        $class = request('class');
        $instance = new $class();
        // dd($instance);
        $search = $instance->where('user_id', $currentUser->id)->findOrFail(request('search_id'));

        if(!$search) {
            return;
        }

        return (new ResultsExport)->download($search->title . '-' . Str::random(16) . '.xlsx');
    }
}
