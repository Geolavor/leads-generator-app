<?php

namespace LeadBrowser\Admin\DataGrids\Mailbox;

use Illuminate\Support\Facades\DB;
use LeadBrowser\UI\DataGrid\DataGrid;

class MailboxDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('mailboxes')
            ->select(
                'mailboxes.id',
                'mailboxes.name',
                'mailboxes.subject',
                'mailboxes.reply',
                'mailboxes.created_at',
                DB::raw('COUNT(DISTINCT ' . DB::getTablePrefix() . 'mailbox_attachments.id) as attachments')
            )
            ->leftJoin('mailbox_attachments', 'mailboxes.id', '=', 'mailbox_attachments.mailbox_id')
            ->groupBy('mailboxes.id')
            ->where('folders', 'like', '%"' . request('route') . '"%')
            ->whereNull('parent_id');

        $this->addFilter('id', 'mailboxes.id');
        $this->addFilter('name', 'mailboxes.name');
        $this->addFilter('created_at', 'mailboxes.created_at');

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
            'index'      => 'attachments',
            'label'      => '<i class="icon attachment-icon"></i>',
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
            'closure'    => function ($row) {
                if ($row->attachments) {
                    return '<i class="icon attachment-icon"></i>';
                }
            },
        ]);

        $this->addColumn([
            'index'    => 'name',
            'label'    => trans('admin::app.datagrid.from'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'    => 'subject',
            'label'    => trans('admin::app.datagrid.subject'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return '<div class="subject-wrapper"><span class="subject-content">' . $row->subject . '</span><span class="reply"> - ' . substr(strip_tags($row->reply), 0, 225) . '<span></div>';
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.created_at'),
            'type'       => 'date_range',
            'searchable' => false,
            'sortable'   => true,
            'closure'    => function ($row) {
                return core()->formatDate($row->created_at);
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
            'title'  => request('route') == 'draft'
                ? trans('ui::app.datagrid.edit')
                : trans('ui::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'mail.view',
            'params' => ['route' => request('route')],
            'icon'   => request('route') == 'draft'
                ? 'pencil-icon'
                : 'eye-icon'
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'mail.delete',
            'params'       => [
                                'type' => request('route') == 'trash'
                                    ? 'delete'
                                    : 'trash'
                            ],
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'email']),
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
        if (request('route') == 'trash') {
            $this->addMassAction([
                'type'   => 'delete',
                'label'  => trans('admin::app.datagrid.move-to-inbox'),
                'action' => route('mail.mass_update', [
                                'folders' => ['inbox'],
                            ]),
                'method' => 'PUT',
            ]);
        }

        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('ui::app.datagrid.delete'),
            'action' => route('mail.mass_delete', [
                            'type' => request('route') == 'trash'
                                ? 'delete'
                                : 'trash',
                        ]),
            'method' => 'PUT',
        ]);
    }
}
