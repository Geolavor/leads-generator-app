<?php

namespace LeadBrowser\API\Http\Controllers\V1\Employee;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Organization\Repositories\EmployeeRepository;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Employee\EmployeeResource;

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
     * @param  \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * @return void
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;

        $this->addEntityTypeInRequest('employees');
    }

    /**
     * Display a listing of the employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->allResources($this->employeeRepository);

        return EmployeeResource::collection($employees);
    }

    /**
     * Show resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $resource = $this->employeeRepository->find($id);

        return new EmployeeResource($resource);
    }

    /**
     * Create the employee.
     *
     * @param  \LeadBrowser\Attribute\Http\Requests\AttributeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('employee.create.before');

        $employee = $this->employeeRepository->create($this->sanitizeRequestedEmployeeData());

        Event::dispatch('employee.create.after', $employee);

        return response([
            'data'    => new EmployeeResource($employee),
            'message' => __('admin::app.employees.create-success'),
        ]);
    }

    /**
     * Update the employee.
     *
     * @param  \LeadBrowser\Attribute\Http\Requests\AttributeForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeForm $request, $id)
    {
        Event::dispatch('employee.update.before', $id);

        $employee = $this->employeeRepository->update($this->sanitizeRequestedEmployeeData(), $id);

        Event::dispatch('employee.update.after', $employee);

        return response([
            'data'    => new EmployeeResource($employee),
            'message' => __('admin::app.employees.update-success'),
        ]);
    }

    /**
     * Remove the employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Event::dispatch('employee.delete.before', $id);

            $this->employeeRepository->delete($id);

            Event::dispatch('employee.delete.after', $id);

            return response([
                'message' => __('admin::app.response.destroy-success', ['name' => __('admin::app.employees.employee')]),
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => __('admin::app.response.destroy-failed', ['name' => __('admin::app.employees.employee')]),
            ], 500);
        }
    }

    /**
     * Mass delete the employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $employeeId) {
            Event::dispatch('contact.employee.delete.before', $employeeId);

            $this->employeeRepository->delete($employeeId);

            Event::dispatch('contact.employee.delete.after', $employeeId);
        }

        return response([
            'message' => __('admin::app.response.destroy-success', ['name' => __('admin::app.employees.title')]),
        ]);
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
