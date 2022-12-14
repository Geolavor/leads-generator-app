<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\System;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Admin\Notifications\Claim\DataClaim;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Core\Models\BlackList;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{
     /**
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::system.claim');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {

        $this->validate(request(), [
            'email'            => 'required|email|unique:black_list,email',
        ]);

        $data = request()->all();

        $token = Str::random(80);
        
        // $token
        $report = new BlackList();
        $report->email = $data['email'];
        $report->token = $token;
        $report->additional = $data['additional'];
        $report->status_id = 1;
        $report->save();

        try {
            Mail::queue(new DataClaim(
                $data['email'],
                $token
            ));
        } catch (\Exception $e) {
            report($e);
        }

        session()->flash('success', trans('admin::app.claim.create-success'));

        return redirect()->route('claim.create');
    }

    public function verify($token = null)
    {
        $report = BlackList::where('token', $token)->first();
        $report->status_id = 2;
        $report->save();

        session()->flash('success', 'We received your deletion request. Your data will be removed from our service within the next 5 working days.');
        return redirect()->route('claim.create');
    }
}
