<?php

namespace LeadBrowser\Admin\DataGrids\Search;

use LeadBrowser\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchWebsiteDataGrid extends DataGrid
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

        $this->export = bouncer()->hasPermission('crm.persons.export') ? true : false;
    }
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('search_websites')
            ->addSelect(
                'search_websites.id',
                'search_websites.urls',
                'search_websites.user_id',
                'search_websites.has_items',
                'search_websites.status_id',
                'search_websites.total_price',
                'users.name as user_name'
            )
            ->leftJoin('users', 'search_websites.user_id', '=', 'users.id');

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $queryBuilder->whereIn('search_websites.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
            } else {
                $queryBuilder->where('search_websites.user_id', $currentUser->id);
            }
        }

        // $this->addFilter('id', 'search_websites.id');

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
                $websites = explode(",", $row->urls);
                return count($websites) + 1;
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
            'route'  => 'search.websites.view',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'search.websites.delete',
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
            'action' => route('search.websites.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
