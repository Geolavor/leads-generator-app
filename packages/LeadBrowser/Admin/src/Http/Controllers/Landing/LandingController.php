<?php

namespace LeadBrowser\Admin\Http\Controllers\Landing;

use LeadBrowser\Admin\Http\Controllers\Controller;

class LandingController extends Controller
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin::landing.index');
    }
}
