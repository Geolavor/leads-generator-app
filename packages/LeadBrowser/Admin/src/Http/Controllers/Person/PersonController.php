<?php

namespace LeadBrowser\Admin\Http\Controllers\Person;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Models\Person;
use LeadBrowser\Organization\Repositories\PersonRepository;

class PersonController extends Controller
{
    /**
     * Person repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\PersonRepository
     */
    protected $personRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Organization\Repositories\PersonRepository  $personRepository
     *
     * @return void
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;

        request()->request->add(['entity_type' => 'persons']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Person\PersonDataGrid::class)->toJson();
        }

        return view('admin::persons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('person.create.before');

        $person = $this->personRepository->create($this->sanitizeRequestedPersonData());

        Event::dispatch('person.create.after', $person);

        session()->flash('success', trans('admin::app.persons.create-success'));

        return redirect()->route('persons.index');
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $person = $this->personRepository->findOrFail($id);

        return view('admin::persons.view', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $person = $this->personRepository->findOrFail($id);

        return view('admin::persons.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeForm $request, $id)
    {
        Event::dispatch('person.update.before', $id);

        $person = $this->personRepository->update($this->sanitizeRequestedPersonData(), $id);

        Event::dispatch('person.update.after', $person);

        session()->flash('success', trans('admin::app.persons.update-success'));

        return redirect()->route('persons.index');
    }

    /**
     * Search person results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->personRepository->findWhere([
            ['name', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = $this->personRepository->findOrFail($id);

        try {
            Event::dispatch('person.delete.before', $id);

            $this->personRepository->delete($id);

            Event::dispatch('person.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.persons.person')]),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.persons.person')]),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $personId) {
            Event::dispatch('organization.person.delete.before', $personId);

            $this->personRepository->delete($personId);

            Event::dispatch('organization.person.delete.after', $personId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.persons.title')])
        ]);
    }

    /**
     * Score the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function score()
    {
        // $person = $this->personRepository->findOrFail($id);

        $person = Person::findOrFail(request('person_id'));
        $person->score = request('score');
        $person->save();

        session()->flash('success', trans('admin::app.persons.changed-score'));
        return redirect()->back();
    }

    /**
     * Sanitize requested person data and return the clean array.
     *
     * @return array
     */
    private function sanitizeRequestedPersonData(): array
    {
        $data = request()->all();

        $data['contact_numbers'] = collect($data['contact_numbers'])->filter(function ($number) {
            return ! is_null($number['value']);
        })->toArray();

        return $data;
    }
}
