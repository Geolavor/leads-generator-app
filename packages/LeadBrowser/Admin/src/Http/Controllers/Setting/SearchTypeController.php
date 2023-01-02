<?php

namespace LeadBrowser\Admin\Http\Controllers\Setting;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Search\Repositories\SearchTypeRepository;

class SearchTypeController extends Controller
{
    /**
     * SearchTypeRepository object
     *
     * @var \LeadBrowser\User\Repositories\SearchTypeRepository
     */
    protected $searchTypeRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Lead\Repositories\SearchTypeRepository  $searchTypeRepository
     * @return void
     */
    public function __construct(SearchTypeRepository $searchTypeRepository)
    {
        $this->searchTypeRepository = $searchTypeRepository;
    }

    /**
     * Display a listing of the type.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Setting\SearchTypeDataGrid::class)->toJson();
        }

        return view('admin::settings.search.types.index');
    }

    /**
     * Store a newly created type in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|unique:lead_types,name'
        ]);
        
        if ($validator->fails()) {
            session()->flash('warning', trans('admin::app.settings.types.name-exists'));

            return redirect()->back();
        }

        Event::dispatch('settings.type.create.before');

        $type = $this->searchTypeRepository->create(request()->all());

        Event::dispatch('settings.type.create.after', $type);

        session()->flash('success', trans('admin::app.settings.types.create-success'));

        return redirect()->route('settings.search.types.index');
    }

    /**
     * Show the form for editing the specified type.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $type = $this->searchTypeRepository->findOrFail($id);

        return view('admin::settings.types.edit', compact('type'));
    }

    /**
     * Update the specified type in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|unique:lead_types,name,' . $id,
        ]);

        Event::dispatch('settings.type.update.before', $id);

        $type = $this->searchTypeRepository->update(request()->all(), $id);

        Event::dispatch('settings.type.update.after', $type);

        session()->flash('success', trans('admin::app.settings.types.update-success'));

        return redirect()->route('settings.search.types.index');
    }

    /**
     * Remove the specified type from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = $this->searchTypeRepository->findOrFail($id);

        try {
            Event::dispatch('settings.type.delete.before', $id);

            $this->searchTypeRepository->delete($id);

            Event::dispatch('settings.type.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.settings.types.delete-success'),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.settings.types.delete-failed'),
            ], 400);
        }

        return response()->json([
            'message' => trans('admin::app.settings.types.delete-failed'),
        ], 400);
    }
}
