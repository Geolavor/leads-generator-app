<?php

namespace LeadBrowser\Admin\DataGrids\Order;

use Illuminate\Support\Facades\DB;
use LeadBrowser\UI\DataGrid\DataGrid;

class InvoicesTransactionsDatagrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('order_transactions')
            ->leftJoin('invoices as inv', 'order_transactions.invoice_id', '=', 'inv.id')
            ->select('order_transactions.id as id', 'order_transactions.transaction_id as transaction_id', 'order_transactions.invoice_id as invoice_id', 'order_transactions.created_at as created_at')
            ->where('order_transactions.invoice_id', request('id'));

        $this->addFilter('id', 'order_transactions.id');
        $this->addFilter('transaction_id', 'order_transactions.transaction_id');
        $this->addFilter('order_id', 'ors.increment_id');
        $this->addFilter('created_at', 'order_transactions.created_at');

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
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'transaction_id',
            'label'      => trans('admin::app.datagrid.transaction-id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.transaction-date'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
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
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'sales.transactions.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}
