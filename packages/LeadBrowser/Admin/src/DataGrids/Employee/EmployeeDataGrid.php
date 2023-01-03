<?php

namespace LeadBrowser\Admin\DataGrids\Employee;

use Illuminate\Support\Facades\DB;
use LeadBrowser\Admin\Traits\ProvideDropdownOptions;
use LeadBrowser\UI\DataGrid\DataGrid;

class EmployeeDataGrid extends DataGrid
{
    use ProvideDropdownOptions;

    /**
     * Export option.
     *
     * @var boolean
     */
    protected $export;

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // $this->export = bouncer()->hasPermission('crm.employees.export') ? true : false;
    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('employees')
            ->addSelect(
                'employees.id',
                'employees.name as employee_name',
                'employees.emails',
                'employees.contact_numbers',
                'employees.social_media',
                'organizations.title as organization',
                'employees.role as role'
            )
            ->leftJoin('organizations', 'employees.organization_id', '=', 'organizations.id');

        $this->addFilter('id', 'employees.id');
        $this->addFilter('employee_name', 'employees.name');
        $this->addFilter('organization', 'organizations.id');

        $this->setQueryBuilder($queryBuilder);

        $currentUser = auth()->guard('user')->user();
        
        // if ($currentUser->view_permission != 'global') {
        //     if ($currentUser->view_permission == 'group') {
        //         $queryBuilder->whereIn('employees.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
        //     } else {
        //         $queryBuilder->where('employees.user_id', $currentUser->id);
        //     }
        // }
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        // $this->addColumn([
        //     'index'      => 'id',
        //     'label'      => trans('admin::app.datagrid.id'),
        //     'type'       => 'string',
        //     'sortable'   => true,
        // ]);

        $this->addColumn([
            'index'    => 'employee_name',
            'label'    => trans('admin::app.datagrid.name'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'    => 'emails',
            'label'    => trans('admin::app.datagrid.emails'),
            'type'     => 'string',
            'sortable' => false,
            'closure'  => function ($row) {
                $emails = json_decode($row->emails, true);

                if ($emails) {
                    $emails = collect($emails)->pluck('value')->join(', ');
                }

                $css = '<span class="email-status email-status-sm email-status-primary" style="width: 10px;height: 10px;background: #00cd00;display: inline-block;border-radius: 50%;"></span>';

                return $css . ' ' . $emails;
            },
        ]);

        $this->addColumn([
            'index'    => 'contact_numbers',
            'label'    => trans('admin::app.datagrid.contact_numbers'),
            'type'     => 'string',
            'sortable' => false,
            'closure'  => function ($row) {
                $contactNumbers = json_decode($row->contact_numbers, true);

                if ($contactNumbers) {
                    return collect($contactNumbers)->pluck('value')->join(', ');
                }
            },
        ]);

        $this->addColumn([
            'index'    => 'role',
            'label'    => trans('admin::app.datagrid.role'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        // $this->addColumn([
        //     'index'            => 'organization',
        //     'label'            => trans('admin::app.datagrid.organization_name'),
        //     'type'             => 'dropdown',
        //     'dropdown_options' => $this->getOrganizationDropdownOptions(),
        //     'sortable'         => false,
        //     'closure'          => function ($row) {
        //         return strlen($row->organization) > 14 ? substr($row->organization, 0, 14) . '...' : $row->organization;
        //     }
        // ]);
        $this->addColumn([
            'index'            => 'organization',
            'label'            => trans('admin::app.datagrid.organization_name'),
            // 'type'             => 'dropdown',
            // 'dropdown_options' => $this->getOrganizationDropdownOptions(),
            'sortable'         => false,
            'closure'  => function ($row) {
                return strlen($row->organization) > 14 ? substr($row->organization, 0, 14) . '...' : $row->organization;
            },
        ]);

    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('ui::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'employees.view',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'  => trans('ui::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'employees.edit',
            'icon'   => 'pencil-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'employees.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => trans('admin::app.employees.employee')]),
            'icon'         => 'trash-icon',
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('ui::app.datagrid.delete'),
            'action' => route('employees.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
