<?php

namespace LeadBrowser\Admin\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->guard('user')->user()->id);

        return view('admin::user.billing.index', [
            'invoices' => $user->invoices(),
            'transactions' => $user->balanceTransactions(),
            'invoices' => $user->invoices()
        ]);
    }

    public function download(Request $request, $invoiceId)
    {
        $user = User::findOrFail(auth()->guard('user')->user()->id);
        
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'    => 'LeadBrowser',
            'product'   => $user->subscription(),
        ]);
    }
}
