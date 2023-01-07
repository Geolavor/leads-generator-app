<?php

namespace LeadBrowser\Admin\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    public function index()
    {
        $integrations = DB::table('integrations')->get();

        return view('admin::user.integrations.index', [
            'integrations' => $integrations,
        ]);
    }
}