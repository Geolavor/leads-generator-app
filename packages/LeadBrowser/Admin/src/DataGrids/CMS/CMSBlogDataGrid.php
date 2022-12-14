<?php

namespace LeadBrowser\Admin\DataGrids\CMS;

use Illuminate\Support\Facades\DB;
use LeadBrowser\UI\DataGrid\DataGrid;

class CMSBlogDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cms_blogs')
            ->select('cms_blogs.id', 'cms_blog_translations.blog_title', 'cms_blog_translations.url_key')
            ->leftJoin('cms_blog_translations', function($leftJoin) {
                $leftJoin->on('cms_blogs.id', '=', 'cms_blog_translations.cms_blog_id')
                         ->where('cms_blog_translations.locale', app()->getLocale());
            });

        $this->addFilter('id', 'cms_blogs.id');

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
            'index'      => 'blog_title',
            'label'      => trans('admin::app.cms.blogs.blog-title'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'url_key',
            'label'      => trans('admin::app.datagrid.url'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                return '<a target="_blank" href="/blog/' . $row->url_key . '">' . $row->url_key . '</a>';
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'cms.blogs.edit',
            'icon'   => 'icon pencil-icon',
        ]);
 
        $this->addAction([
            'title'  => trans('admin::app.datagrid.delete'),
            'method' => 'POST',
            'route'  => 'cms.blogs.delete',
            'icon'   => 'icon trash-icon',
        ]);
    } 

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('cms.blogs.mass-delete'),
            'method' => 'POST',
        ]);
    }
}
