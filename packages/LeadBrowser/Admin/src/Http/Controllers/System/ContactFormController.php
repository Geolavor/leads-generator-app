<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\System;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Admin\Notifications\Claim\DataClaim;
use LeadBrowser\Admin\Notifications\Organization\OrganizationForm;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Core\Models\BlackList;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class OrganizationFormController extends Controller
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
        return view('admin::system.contact');
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
            'email'              => 'required|email',
            'subject'            => 'required',
            'content'            => 'required',
        ]);

        $data = request()->all();

        try {
            Mail::queue(new OrganizationForm($data['email'], $data['subject'], $data['content']));
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('landing.home')->with('success', 'Your message has been sent!');
    }
}
