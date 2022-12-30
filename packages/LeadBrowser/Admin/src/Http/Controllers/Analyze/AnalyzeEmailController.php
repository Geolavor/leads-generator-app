<?php

// declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Analyze;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Core\Traits\BlackListTrait;
use Egulias\EmailValidator\EmailValidator;
use LeadBrowser\Extractor\Traits\Email\EmailExtractor;
use LeadBrowser\Organization\Models\Analysis;

class AnalyzeEmailController extends Controller
{
    use BlackListTrait, EmailExtractor;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::analyze.email.create');
    }

    /**
     * @param $id
     * @return object
     */
    public function store()
    {
        $this->validate(request(), [
            'email'            => 'required|email',
        ]);

        $email = request('email');

        if(!$this->checkEmail($email)) {
            session()->flash('warning', 'This email address has been blocked or is not displayed due to GDPR. Please note that we only check business addresses.');
            return redirect()->back();
        }
        
        $status = 'success';

        session()->flash('success', trans('admin::app.search.create-success'));

        return view('admin::analyze.email.view', compact('data', 'email', 'status'));
    }

    /**
     * TODO
     */
    public function transfer()
    {

        $email = request('email');

        // /**
        //  * Check if company is already saved in the organization
        //  */
        // $organization = Organization::where('user_id', auth()->guard('user')->user()->id)->where('name', $result->organization->title)->first();
        // if($organization) {
        //     return redirect()->back()->with('message','You already added this company to contact!');
        // }

        // $organization = $this->organizationRepository->create([
        //     'entity_type' => 'organizations',
        //     'name' => $result->organization->title,
        //     'address' => $result->organization->location,
        //     'user_id' => auth()->guard('user')->user()->id
        // ]);

        // foreach ($emails as $key => $value) {

        //     $emails = [];
        //     $phones = [];

        //     $name = explode("@", $value->email);

        //     array_push($emails, ["label" => "work", "value" => $value->email]);
        //     array_push($phones, ["label" => "work", "value" => '']);

        //     $this->personRepository->create([
        //         'entity_type' => 'persons',
        //         'name' => ucfirst($name[0]),
        //         'emails' => $emails,
        //         'contact_numbers' => $phones,
        //         'organization_id' => $organization->id,
        //         'user_id' => auth()->guard('user')->user()->id
        //     ]);

        // }

        // session()->flash('success', trans('admin::app.persons.create-success'));

        // return redirect()->back()->with('message','Operation Successful !');
    }
}
