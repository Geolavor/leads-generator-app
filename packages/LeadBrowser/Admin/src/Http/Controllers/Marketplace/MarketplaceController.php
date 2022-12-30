<?php

namespace LeadBrowser\Admin\Http\Controllers\Marketplace;

use Carbon\Carbon;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Admin\Helpers\Dashboard as DashboardHelper;

class MarketplaceController extends Controller
{
    /**
     * Dashboard object
     *
     * @var \LeadBrowser\Admin\Helpers\Dashboard
     */
    protected $dashboardHelper;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Admin\Helpers\DashboardHelper  $dashboardHelper
     * @return void
     */
    public function __construct(DashboardHelper $dashboardHelper)
    {
        $this->dashboardHelper = $dashboardHelper;

        $this->dashboardHelper->setCards();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {$cards = $this->dashboardHelper->getCards();

        if ($dateRange = request('date-range')) {
            $dateRange = explode(",", $dateRange);

            $endDate = $dateRange[1];
            $startDate = $dateRange[0];
        } else {
            $endDate = Carbon::now()->format('Y-m-d');
            
            $startDate = Carbon::now()->subMonth()->addDays(1)->format('Y-m-d');
        }

        return view('admin::dashboard.index', compact('cards', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function template()
    {
        return view('admin::dashboard.template');
    }
}