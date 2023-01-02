<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Payments;

use Illuminate\Http\Request;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Payment\Models\Plan;

class PlanController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function index()
    {
        // $type = request()->get('monthly');
        $plans = Plan::all();
        return view('admin::plans.index', compact('plans'));
    }

    /**
     * Show the Plan.
     *
     * @return mixed
     */
    public function show(Plan $plan, Request $request)
    {   
        $paymentMethods = $request->user()->paymentMethods();

        $intent = $request->user()->createSetupIntent();
        
        return view('admin::plans.view', compact('plan', 'intent'));
    }
}