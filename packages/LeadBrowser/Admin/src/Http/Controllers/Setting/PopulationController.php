<?php

namespace LeadBrowser\Admin\Http\Controllers\Setting;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Core\Repositories\PopulationRepository;

class PopulationController extends Controller
{
    /**
     * PopulationRepository object
     *
     * @var \LeadBrowser\Core\Repositories\PopulationRepository
     */
    protected $populationRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Core\Repositories\PopulationRepository  $populationRepository
     * @return void
     */
    public function __construct(PopulationRepository $populationRepository)
    {
        $this->populationRepository = $populationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Setting\PopulationDataGrid::class)->toJson();
        }

        return view('admin::settings.populations.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|unique:population_sources,name',
            'number' => 'required',
        ]);
        
        if ($validator->fails()) {
            session()->flash('warning', trans('admin::app.settings.populations.name-exists'));

            return redirect()->back();
        }

        Event::dispatch('settings.population.create.before');

        $population = $this->populationRepository->create(request()->all());

        Event::dispatch('settings.population.create.after', $population);

        session()->flash('success', trans('admin::app.settings.populations.create-success'));

        return redirect()->route('settings.populations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $population = $this->populationRepository->findOrFail($id);

        return view('admin::settings.populations.edit', compact('population'));
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
            'name' => 'required|unique:population_sources,name,' . $id,
        ]);

        Event::dispatch('settings.population.update.before', $id);

        $population = $this->populationRepository->update(request()->all(), $id);

        Event::dispatch('settings.population.update.after', $population);

        session()->flash('success', trans('admin::app.settings.populations.update-success'));

        return redirect()->route('settings.populations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $population = $this->populationRepository->findOrFail($id);

        try {
            Event::dispatch('settings.population.delete.before', $id);

            $this->populationRepository->delete($id);

            Event::dispatch('settings.population.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.settings.populations.delete-success'),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.settings.populations.delete-failed'),
            ], 400);
        }

        return response()->json([
            'message' => trans('admin::app.settings.populations.delete-failed'),
        ], 400);
    }
}
