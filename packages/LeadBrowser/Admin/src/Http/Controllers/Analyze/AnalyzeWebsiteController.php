<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Analyze;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Extractor\Services\Extractor;
use LeadBrowser\Organization\Traits\Organizationable;
// use Spatie\Crawler\Crawler;

class AnalyzeWebsiteController extends Controller
{
    use Organizationable;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::analyze.website.create');
    }

    /**
     * @param $id
     * @return object
     */
    public function store()
    {
        $website = request('website');

        // TODO: Create request validation
        if(!$website) return;

        // $data = $this->searchOrganizationBy($website, 'website');

        // if(!$data) {
            $extractor = new Extractor();
            $data = (array) $extractor->searchFor($website);
        // }

        session()->flash('success', trans('admin::app.search.create-success'));

        return view('admin::analyze.website.view', compact('data'));
    }

    /**
     * TODO
     */
    public function transfer()
    {
        $this->validate(request(), [
            'website'            => 'required',
        ]);
        $email = request('email');

        // /**
        //  * Check if company is already saved in the organization
        //  */
        // $organization = Organization::where('user_id', auth()->guard('user')->user()->id)->where('name', $result->place->title)->first();
        // if($organization) {
        //     return redirect()->back()->with('message','You already added this company to contact!');
        // }

        // $organization = $this->organizationRepository->create([
        //     'entity_type' => 'organizations',
        //     'name' => $result->place->title,
        //     'address' => $result->place->location,
        //     'user_id' => auth()->guard('user')->user()->id
        // ]);

        // foreach ($emails as $key => $value) {

        //     $emails = [];
        //     $phones = [];

        //     $name = explode("@", $value->email);

        //     array_push($emails, ["label" => "work", "value" => $value->email]);
        //     array_push($phones, ["label" => "work", "value" => '']);

        //     $this->employeeRepository->create([
        //         'entity_type' => 'employees',
        //         'name' => ucfirst($name[0]),
        //         'emails' => $emails,
        //         'contact_numbers' => $phones,
        //         'organization_id' => $organization->id,
        //         'user_id' => auth()->guard('user')->user()->id
        //     ]);

        // }

        // session()->flash('success', trans('admin::app.employees.create-success'));

        // return redirect()->back()->with('message','Operation Successful !');
    }
}
