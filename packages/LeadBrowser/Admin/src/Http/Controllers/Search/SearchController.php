<?php

namespace LeadBrowser\Admin\Http\Controllers\Search;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Admin\Notifications\Organization\OrganizationForm;
use Illuminate\Support\Facades\Mail;

class SearchController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin::search.index');
    }
}
