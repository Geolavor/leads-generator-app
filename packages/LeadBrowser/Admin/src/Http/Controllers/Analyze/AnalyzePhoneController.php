<?php

// declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Analyze;

use App\Services\GoogleMapService;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Payment\Models\Usage;
use LeadBrowser\Organization\Services\SerpOrganizationsService;
use LeadBrowser\Organization\Traits\Organizationable;
use LeadBrowser\User\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyzePhoneController extends Controller
{
    use Organizationable;
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::analyze.phone.create');
    }

    /**
     * @param $id
     * @return object
     */
    public function store()
    {
        $currentUser = auth()->guard('user')->user();
        $subscription = $currentUser->subscription;
        $usage = $currentUser->usage;

        $phone = request('phone');

        /**
         * If user dosen't have enough coins in wallet
         */
        if(($currentUser->bonus_coin > 0) && $currentUser->bonus_coin < 1 || ($usage['available'] - $usage['used']) < 1) {
            session()->flash('warning', trans('admin::app.search.you-dont-have-enough-coins'));
            return redirect()->back();
        }

        $data = $this->searchOrganizationBy($phone, 'formatted_phone_number');

        if(!$data) {
            /**
             * Start search organization
             */
            $searchService = new SerpOrganizationsService();
            $data = $searchService->searchByPhone($phone);

            $googleMapService = new GoogleMapService('');

            $data = $googleMapService->generateOrganizationDetail($data['candidates'][0]['organization_id']);

            // foreach ($data['candidates'] as $key => $value) {
                // $value = $googleMapService->generateOrganizationDetail($data['organization_id']);
            // }
        }
        

        /**
         * If user has bonus coin
         */
        if ($currentUser->bonus_coin > 0) {
            User::where('id', $currentUser->id)->update([
                'bonus_coin' => DB::raw('bonus_coin - 1'),
            ]);
        }

        if ($currentUser->bonus_coin == 0) {
            Usage::where('subscription_id', $subscription['id'])->update([
                'used' => DB::raw('used + 1'),
            ]);
        }

        session()->flash('success', trans('admin::app.search.create-success'));

        return view('admin::analyze.phone.view', compact('data'));
    }

    /**
     * TODO
     */
    public function transfer()
    {
        $this->validate(request(), [
            'email'            => 'required|email',
        ]);
        
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
