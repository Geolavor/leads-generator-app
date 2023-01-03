<?php

namespace LeadBrowser\Admin\DataGrids\Search;

use LeadBrowser\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchPhoneDataGrid extends DataGrid
{
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

        $this->export = bouncer()->hasPermission('crm.employees.export') ? true : false;
    }
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('search_phones')
            ->addSelect(
                'search_phones.id',
                'search_phones.urls',
                'search_phones.user_id',
                'search_phones.has_items',
                'search_phones.status_id',
                'search_phones.total_price',
                'users.name as user_name'
            )
            ->leftJoin('users', 'search_phones.user_id', '=', 'users.id');

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $queryBuilder->whereIn('search_phones.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
            } else {
                $queryBuilder->where('search_phones.user_id', $currentUser->id);
            }
        }

        // $this->addFilter('id', 'search_phones.id');

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
            'index'    => 'urls',
            'label'    => trans('admin::app.datagrid.urls'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return Str::limit($row->urls, 20);
            }
        ]);

        $this->addColumn([
            'index'    => 'count',
            'label'    => trans('admin::app.datagrid.count'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $phones = explode(",", $row->urls);
                return count($phones) + 1;
            }
        ]);

        $this->addColumn([
            'index'    => 'status_id',
            'label'    => trans('admin::app.datagrid.status'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {

                if ($row->status_id == 3) {
                    $badge = 'success';
                    $text = 'Finish';
                } else if ($row->status_id == 4) {
                    $badge = 'danger';
                    $text = 'Error';
                } else {
                    $badge = 'primary';
                    $text = 'Active';
                }

                return "<span class='badge badge-round badge-{$badge}'></span>" . $text;
            },
        ]);

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission == 'global') {
            $this->addColumn([
                'index'    => 'user_name',
                'label'    => trans('admin::app.datagrid.owner'),
                'type'     => 'string',
                'sortable' => true
            ]); 
        }
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
            'route'  => 'search.phones.view',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'search.phones.delete',
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
            'action' => route('search.phones.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
