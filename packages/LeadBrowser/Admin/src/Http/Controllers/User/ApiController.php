<?php

namespace LeadBrowser\Admin\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\User\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function index()
    {
        $tokens = auth()->guard('user')->user()->tokens;

        return view('admin::user.api.index', [
            'tokens' => $tokens,
        ]);
    }
}
