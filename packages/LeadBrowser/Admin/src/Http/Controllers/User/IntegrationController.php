<?php

namespace LeadBrowser\Admin\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\User\Models\User;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->guard('user')->user()->id);

        return view('admin::user.integrations.index', [
            'subscriptions' => $user->subscriptions,
        ]);
    }
}
