<?php

namespace LeadBrowser\Admin\DataGrids\Result;

use Carbon\Carbon;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;

class ResultDataGrid extends DataGrid
{
    /**
     * Export option.
     *
     * @var boolean
     */
    // protected $export;

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // $this->export = bouncer()->hasPermission('results.export') ? true : false;
    }

    // /**
    //  * Place your datagrid extra settings here.
    //  *
    //  * @return void
    //  */
    // public function init()
    // {
    //     $this->setRowProperties([
    //         'backgroundColor' => '#ffd0d6',
    //         'condition' => function ($row) {
    //             if ($row->staus_id > 1) {
    //                 return false;
    //             }
    //             return true;
    //         }
    //     ]);
    // }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        // $currentUser = auth()->guard('user')->user();

        $queryBuilder = DB::table('results')
            ->addSelect(
                'results.id',
                'results.searchable_id',
                'results.searchable_type',
                'results.organization_id',
                'results.stage_id',
                'results.user_id',
                'results.price',
                'results.risk_value',
                'organizations.icon as organization_icon',
                'organizations.title as organization_name',
                // 'organizations.description as organization_description',
                'organizations.rating as organization_rating',
                'organizations.types as organization_types',
                'organizations.website as organization_website',
                'organizations.is_ecommerce as organization_is_ecommerce',
                'organizations.archive as organization_archive',
                'organizations.city as organization_city',
                'organizations.formatted_address as organization_formatted_address',
                'organizations.formatted_phone_number as organization_phone',
            )
            ->leftJoin('organizations', 'results.organization_id', '=', 'organizations.id');
            // ->leftJoin('emails', 'organizations.id', '=', 'emails.organization_id')
            // ->selectRaw('results.*, count(emails.id) as emails_count');

        $currentUser = auth()->guard('user')->user();
        
        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $queryBuilder->whereIn('results.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
            } else {
                $queryBuilder->where('results.user_id', $currentUser->id);
            }
        }

        $id = request('id');
        if ($id) {
            $queryBuilder->where('results.searchable_id', $id);
        }

        // $type = request('type');
        // if($type) {
        //     $queryBuilder->where('results.searchable_type', $type);
        // }
   
        $this->addFilter('id', 'results.id', 'results.searchable_id');
        $this->addFilter('id', 'results.id', 'results.stage_id');
        $this->addFilter('id', 'results.id', 'results.risk_value');
        $this->addFilter('organization_rating', 'organizations.rating');
        $this->addFilter('organization_types', 'organizations.types');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'    => 'organization_icon',
            'label'    => trans('admin::app.datagrid.logotype'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return "<img class='profile-pic' style='max-width:80px;
                background: #f1f1f1;
                padding: 10px;
                border-radius: 5px;' src='" . ($row->organization_icon ?: env('APP_URL') . '/vendor/leadBrowser/admin/assets/images/blank-logotype.png') . "'>";
            },
        ]);

        $this->addColumn([
            'index'    => 'organization_name',
            'label'    => trans('admin::app.datagrid.name'),
            'type'     => 'string',
            'sortable' => true,
            'closure'   => function ($row) {
                return $row->organization_name;//strlen($row->organization_name) > 14 ? substr($row->organization_name, 0, 14) . '...' : $row->organization_name;
            }
        ]);

        // $this->addColumn([
        //     'index'    => 'organization_description',
        //     'label'    => trans('admin::app.datagrid.description'),
        //     'type'     => 'string',
        //     'sortable' => true,
        //     // 'closure'   => function ($row) {
        //     //     $description = strlen($row->organization_description) > 35 ? substr($row->organization_description, 0, 35) . '...' : $row->organization_description;
        //     //     return "<small>" . $description . "</small>";
        //     // }
        // ]);

        $this->addColumn([
            'index'    => 'organization_formatted_address',
            'label'    => trans('admin::app.datagrid.address'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return $row->organization_formatted_address ?? '';
            }
        ]);

        $this->addColumn([
            'index'    => 'risk_value',
            'label'    => trans('admin::app.datagrid.risk-value'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {

                if ($row->risk_value > 8) {
                    $badge = 'warning';
                    $text = 'High';
                } else if ($row->risk_value > 5) {
                    $badge = 'primary';
                    $text = 'Medium';
                } else {
                    $badge = 'success';
                    $text = 'Low';
                }

                return "<span class='badge badge-{$badge}'><small>" . $text . "</small></span>";
            }
        ]);

        $this->addColumn([
            'index'    => 'emails',
            'label'    => trans('admin::app.datagrid.emails'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $organization = Organization::findOrFail($row->organization_id);

                return $organization->prepared_count_emails;
            }
        ]);

        $this->addColumn([
            'index'    => 'workers',
            'label'    => trans('admin::app.datagrid.workers'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $organization = Organization::findOrFail($row->organization_id);

                return $organization->prepared_count_workers;
            }
        ]);

        $this->addColumn([
            'index'    => 'organization_website',
            'label'    => trans('admin::app.datagrid.website'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return $row->organization_website ? ("<a href='$row->organization_website' target='_blank'>" . substr($row->organization_website, 0, 15) . "...</a>") : '-';
            }
        ]);

        $this->addColumn([
            'index'    => 'organization_phone',
            'label'    => trans('admin::app.datagrid.phone'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        // $this->addColumn([
        //     'index'    => 'price',
        //     'label'    => trans('admin::app.datagrid.price'),
        //     'type'     => 'string',
        //     'sortable' => true,
        //     'closure'  => function ($row) {

        //         if ($row->price >= 0.20) {
        //             $badge = 'success';
        //             $text = 'Finish';
        //         } else {
        //             $badge = 'primary';
        //             $text = 'Active';
        //         }

        //         return "<span class='badge badge-{$badge}'><small>" . $row->price . ' ' . core()->currencySymbol(config('app.currency')) . "</small></span>";
        //     },
        // ]);

    }

    /**
     * Prepare tab filters.
     *
     * @return array
     */
    public function prepareTabFilters()
    {
        // $values = $this->pipeline->stages()
        //     ->get(['name', 'code as key', DB::raw('false as isActive')])
        //     ->prepend([
        //         'isActive' => true,
        //         'key'      => 'all',
        //         'name'     => trans('admin::app.datagrid.all'),
        //     ])
        //     ->toArray();

        // $values = ['name' => 'emails'];

        // $this->addTabFilter([
        //     'key'        => 'type',
        //     'type'       => 'pill',
        //     'condition'  => 'eq',
        //     'value_type' => 'lookup',
        //     'values'     => $values,
        // ]);
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
            'route'  => 'results.view',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'results.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'user']),
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
            'action' => route('results.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
