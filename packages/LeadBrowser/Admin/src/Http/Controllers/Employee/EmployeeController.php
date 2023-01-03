<?php

namespace LeadBrowser\Admin\Http\Controllers\Employee;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Models\Employee;
use LeadBrowser\Organization\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    /**
     * Employee repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     *
     * @return void
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;

        request()->request->add(['entity_type' => 'employees']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Employee\EmployeeDataGrid::class)->toJson();
        }

        return view('admin::employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('employee.create.before');

        $employee = $this->employeeRepository->create($this->sanitizeRequestedEmployeeData());

        Event::dispatch('employee.create.after', $employee);

        session()->flash('success', trans('admin::app.employees.create-success'));

        return redirect()->route('employees.index');
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $employee = $this->employeeRepository->findOrFail($id);

        return view('admin::employees.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $employee = $this->employeeRepository->findOrFail($id);

        return view('admin::employees.edit', compact('employee'));
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
        Event::dispatch('employee.update.before', $id);

        $employee = $this->employeeRepository->update($this->sanitizeRequestedEmployeeData(), $id);

        Event::dispatch('employee.update.after', $employee);

        session()->flash('success', trans('admin::app.employees.update-success'));

        return redirect()->route('employees.index');
    }

    /**
     * Search employee results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->employeeRepository->findWhere([
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
        $employee = $this->employeeRepository->findOrFail($id);

        try {
            Event::dispatch('employee.delete.before', $id);

            $this->employeeRepository->delete($id);

            Event::dispatch('employee.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.employees.employee')]),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.employees.employee')]),
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
        foreach (request('rows') as $employeeId) {
            Event::dispatch('organization.employee.delete.before', $employeeId);

            $this->employeeRepository->delete($employeeId);

            Event::dispatch('organization.employee.delete.after', $employeeId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.employees.title')])
        ]);
    }

    /**
     * Score the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function score()
    {
        // $employee = $this->employeeRepository->findOrFail($id);

        $employee = Employee::findOrFail(request('employee_id'));
        $employee->score = request('score');
        $employee->save();

        session()->flash('success', trans('admin::app.employees.changed-score'));
        return redirect()->back();
    }

    /**
     * Sanitize requested employee data and return the clean array.
     *
     * @return array
     */
    private function sanitizeRequestedEmployeeData(): array
    {
        $data = request()->all();

        $data['contact_numbers'] = collect($data['contact_numbers'])->filter(function ($number) {
            return ! is_null($number['value']);
        })->toArray();

        return $data;
    }
}
