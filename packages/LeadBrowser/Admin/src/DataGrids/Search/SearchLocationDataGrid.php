<?php

namespace LeadBrowser\Admin\DataGrids\Search;

use Carbon\CarbonInterval;
use LeadBrowser\Core\Models\City;
use LeadBrowser\Core\Models\Country;
use LeadBrowser\Core\Models\State;
use LeadBrowser\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SearchLocationDataGrid extends DataGrid
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
        $queryBuilder = DB::table('search_locations')
            ->addSelect(
                'search_locations.id',
                'search_locations.user_id',
                'search_locations.title',
                'search_locations.has_items',
                'search_locations.expected_items',
                'search_locations.status_id',
                'search_locations.location',
                'users.name as user_name',
                'users.image as user_image',
                'search_tags.tag_id as tag_id',
                'tags.name as tag_name',
                'tags.color as tag_color',
            )
            ->leftJoin('users', 'search_locations.user_id', '=', 'users.id')
            ->leftJoin('search_tags', 'search_locations.id', '=', 'search_tags.search_id')
            ->leftJoin('tags', 'tags.id', '=', 'search_tags.tag_id');

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $queryBuilder->whereIn('search_locations.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
            } else {
                $queryBuilder->where('search_locations.user_id', $currentUser->id);
            }
        }

        $this->addFilter('id', 'search_locations.id', 'search_locations.expected_items');
        $this->addFilter('tag_name', 'tags.name');

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
            'index'    => 'title',
            'label'    => trans('admin::app.datagrid.title'),
            'type'     => 'string',
            'sortable' => true,
            // 'closure'   => function ($row) {
            //     return strlen($row->title) > 14 ? substr($row->title, 0, 14) . '...' : $row->title;
            // }
        ]);

        $this->addColumn([
            'index'    => 'location',
            'label'    => trans('admin::app.datagrid.location'),
            'sortable' => true,
            'closure'  => function ($row) {
                $location = json_decode($row->location);

                if(isset($location->country)) {
                    $value = Country::where('code', $location->country)->first();
                }

                if(isset($location->state)) {
                    $value = State::findOrFail($location->state);
                }

                if(isset($location->city)) {
                    $value = City::where('name', $location->city)->first();
                }

                if ($value) {
                    return strlen($value->name) > 14 ? substr($value->name, 0, 14) . '...' : $value->name;
                }
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

        $this->addColumn([
            'index'    => 'expected_items',
            'label'    => trans('admin::app.datagrid.quantity'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {

                $percent = '0%';
                $error   = false;
                
                if ($row->has_items != 0) {
                    $calculation = $row->has_items / $row->expected_items;
                    $percent = number_format( $calculation * 100, 0 ) . '%'; 
                }

                if ($row->status_id == 4) {
                    $percent = 100;
                    $error   = true;
                }

                $pattern = ($row->expected_items - $row->has_items) * 15;
                $time = $pattern > 1 ? '(' . CarbonInterval::seconds($pattern)->cascade()->forHumans() . ')' : false;

                $value = $error ? $error : ($percent == 0 ? 'Waiting' : $percent);

                return "
                    <div>
                        <small>Has $row->has_items from $row->expected_items $time</small>
                        <div class='progress' style='height: 15px;border-radius: 5px;'>
                            <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: $percent;' aria-valuenow='$percent' aria-valuemin='0' aria-valuemax='100%'>
                                $value
                            </div>
                        </div>
                    </div>
                ";
            }
        ]);
        // $this->addColumn([
        //     'index'    => 'total_price',
        //     'label'    => trans('admin::app.datagrid.total-price'),
        //     'type'     => 'string',
        //     'sortable' => true,
        //     'closure'  => function ($row) {
        //         return 12;//$row;
        //     }
        // ]);

        $this->addColumn([
            'index'    => 'tags',
            'label'    => trans('admin::app.datagrid.tags'),
            'type'     => 'string',
            'sortable' => true,
            'closure'   => function ($row) {

                $html = '';

                // $html .= '<ul class="tag-list">';
                // $html .= '<li style="background-color:' . $row->tag_color ? $row->tag_color : '#546E7A' . '">' . $row->tag_name . '</li>';
                //     // foreach ($row->tag_name as $key => $tag) {
                //     //     $html .= '<li style="background-color:' . $tag->color ? $tag->color : '#546E7A' . '">' . $tag->name . '</li>';
                //     // }
                // $html .= '</ul>';

                return $html;
            }
        ]);

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission == 'global') {
            $this->addColumn([
                'index'    => 'user_name',
                'label'    => trans('admin::app.datagrid.owner'),
                'type'     => 'string',
                'sortable' => true,
                'closure'  => function ($row) {
                    return $row->user_name;
                    if ($row->user_image) {
                        return '<div class="avatar"><img src="' . Storage::url($row->image_url) . '"></div>' . $row->user_name;
                    } else {
                        return '<div class="avatar"><span class="icon avatar-icon"></span></div>' . $row->user_name;
                    }
                },
            ]); 
        }
    }

    /**
     * Prepare tab filters.
     *
     * @return array
     */
    public function prepareTabFilters()
    {
        $this->addTabFilter([
            'key'       => 'status_id',
            'type'      => 'pill',
            'condition' => 'eq',
            'values'    => [
                [
                    'name'     => 'admin::app.search.all',
                    'isActive' => true,
                    'key'      => '1',
                ], [
                    'name'     => 'admin::app.search.active',
                    'isActive' => false,
                    'key'      => '2',
                ], [
                    'name'     => 'admin::app.search.finish',
                    'isActive' => false,
                    'key'      => '3',
                ]
            ]
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
            'route'  => 'search.location.view',
            'icon'   => 'eye-icon',
        ]);

        $this->addAction([
            'title'        => trans('ui::app.datagrid.delete'),
            'method'       => 'DELETE',
            'route'        => 'search.location.delete',
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
            'action' => route('search.location.mass_delete'),
            'method' => 'PUT',
        ]);
    }
}
