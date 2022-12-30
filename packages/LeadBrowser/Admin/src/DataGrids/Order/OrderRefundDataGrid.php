<?php

namespace LeadBrowser\Admin\DataGrids\Order;

use Illuminate\Support\Facades\DB;
use LeadBrowser\UI\DataGrid\DataGrid;

class OrderRefundDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('refunds')
            ->select('refunds.id', 'orders.increment_id', 'refunds.state', 'refunds.base_grand_total', 'refunds.created_at')
            ->leftJoin('orders', 'refunds.order_id', '=', 'orders.id');

        $this->addFilter('id', 'refunds.id');
        $this->addFilter('increment_id', 'orders.increment_id');
        $this->addFilter('state', 'refunds.state');
        $this->addFilter('base_grand_total', 'refunds.base_grand_total');
        $this->addFilter('created_at', 'refunds.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'increment_id',
            'label'      => trans('admin::app.datagrid.order-id'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'base_grand_total',
            'label'      => trans('admin::app.datagrid.refunded'),
            'type'       => 'price',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.refund-date'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'sales.refunds.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}