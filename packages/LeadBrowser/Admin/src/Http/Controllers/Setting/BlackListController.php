<?php

namespace LeadBrowser\Admin\Http\Controllers\Setting;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Core\Repositories\BlackListRepository;

class BlackListController extends Controller
{
    /**
     * BlackListRepository object
     *
     * @var \LeadBrowser\Core\Repositories\BlackListRepository
     */
    protected $reportsRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Core\Repositories\BlackListRepository  $reportsRepository
     * @return void
     */
    public function __construct(BlackListRepository $reportsRepository)
    {
        $this->reportsRepository = $reportsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Setting\BlackListDataGrid::class)->toJson();
        }

        return view('admin::settings.reports.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|unique:reports_sources,name',
            'number' => 'required',
        ]);
        
        if ($validator->fails()) {
            session()->flash('warning', trans('admin::app.settings.reports.name-exists'));

            return redirect()->back();
        }

        Event::dispatch('settings.reports.create.before');

        $reports = $this->reportsRepository->create(request()->all());

        Event::dispatch('settings.reports.create.after', $reports);

        session()->flash('success', trans('admin::app.settings.reports.create-success'));

        return redirect()->route('settings.reports.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $reports = $this->reportsRepository->findOrFail($id);

        return view('admin::settings.reports.edit', compact('reports'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|unique:reports_sources,name,' . $id,
        ]);

        Event::dispatch('settings.reports.update.before', $id);

        $reports = $this->reportsRepository->update(request()->all(), $id);

        Event::dispatch('settings.reports.update.after', $reports);

        session()->flash('success', trans('admin::app.settings.reports.update-success'));

        return redirect()->route('settings.reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reports = $this->reportsRepository->findOrFail($id);

        try {
            Event::dispatch('settings.reports.delete.before', $id);

            $this->reportsRepository->delete($id);

            Event::dispatch('settings.reports.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.settings.reports.delete-success'),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.settings.reports.delete-failed'),
            ], 400);
        }

        return response()->json([
            'message' => trans('admin::app.settings.reports.delete-failed'),
        ], 400);
    }
}
