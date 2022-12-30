<?php

namespace LeadBrowser\Admin\DataGrids\Organization;

use Carbon\Carbon;
use LeadBrowser\Organization\Models\Email;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Organization\Repositories\PersonRepository;
use LeadBrowser\UI\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;

class OrganizationDataGrid extends DataGrid
{
    /**
     * Export option.
     *
     * @var boolean
     */
    protected $export;

   /**
     * Person repository instance.
     *
     * @var \LeadBrowser\Organization\Repositories\PersonRepository
     */
    protected $personRepository;

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct(PersonRepository $personRepository)
    {
        parent::__construct();

        $this->personRepository = $personRepository;
    }

    /**
     * Organization your datagrid extra settings here.
     *
     * @return void
     */
    public function init()
    {
        $this->setRowProperties([
            'backgroundColor' => '#ffd0d6',
            'condition' => function ($row) {
                if ($row->crawled_at) {
                    return false;
                }
                return true;
            }
        ]);
    }

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        // $currentUser = auth()->guard('user')->user();

        $queryBuilder = DB::table('organizations')
            ->addSelect(
                'organizations.id',
                'organizations.icon',
                'organizations.title',
                // 'organizations.description',
                'organizations.rating',
                'organizations.types',
                'organizations.website',
                'organizations.is_ecommerce',
                'organizations.archive',
                'organizations.country',
                'organizations.city',
                'organizations.formatted_address as formatted_address',
                'organizations.size_range',
                'organizations.crawled_at',
                // 'organization_tags.tag_id as tag_id',
                // 'tags.name as tag_name',
                // 'tags.color as tag_color',
            );
            //->leftJoin('results', 'organizations.id', '=', 'results.organization_id');
            // ->where('crawled_at', '!=', null);
            // ->leftJoin('organization_tags', 'organizations.id', '=', 'organization_tags.organization_id')
            // ->leftJoin('tags', 'tags.id', '=', 'organization_tags.tag_id');

        $currentUser = auth()->guard('user')->user();
        
        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                // $queryBuilder->whereIn('results.user_id', $this->userRepository->getCurrentUserGroupsUserIds());
            } else {
                // $queryBuilder->where('results.user_id', $currentUser->id);
            }
        }
   
        $this->addFilter('title', 'organizations.title');
        $this->addFilter('rating', 'organizations.rating');
        $this->addFilter('types', 'organizations.types');
        $this->addFilter('country', 'organizations.country');

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
            'index'    => 'image',
            'label'    => trans('admin::app.datagrid.logotype'),
            'type'     => 'string',
            'closure'  => function ($row) {
                return "<img class='profile-pic' style='max-width:80px;
                background: #f1f1f1;
                padding: 10px;
                border-radius: 5px;' src='" . ($row->icon ?: env('APP_URL') . '/vendor/leadBrowser/admin/assets/images/blank-logotype.png') . "'>";
            },
        ]);

        $this->addColumn([
            'index'    => 'title',
            'label'    => trans('admin::app.datagrid.name'),
            'type'     => 'string',
            'sortable' => true,
        ]);

        // $this->addColumn([
        //     'index'    => 'description',
        //     'label'    => trans('admin::app.datagrid.description'),
        //     'type'     => 'string',
        //     'sortable' => true,
        //     // 'closure'   => function ($row) {
        //     //     $description = strlen($row->description) > 35 ? substr($row->description, 0, 35) . '...' : $row->description;
        //     //     return "<small>" . $description . "</small>";
        //     // }
        // ]);

        $this->addColumn([
            'index'    => 'types',
            'label'    => trans('admin::app.datagrid.types'),
            'type'     => 'string',
            'sortable' => true
        ]);

        $this->addColumn([
            'index'    => 'country',
            'label'    => trans('admin::app.datagrid.country'),
            'type'     => 'string',
            'sortable' => true
        ]);

        $this->addColumn([
            'index'    => 'city',
            'label'    => trans('admin::app.datagrid.city'),
            'type'     => 'string',
            'sortable' => true
        ]);

        $this->addColumn([
            'index'    => 'formatted_address',
            'label'    => trans('admin::app.datagrid.address'),
            'type'     => 'string',
            'sortable' => true
        ]);

        $this->addColumn([
            'index'    => 'emails',
            'label'    => trans('admin::app.datagrid.emails'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $organization = Organization::findOrFail($row->id);

                return $organization->prepared_count_emails;
            }
        ]);

        $this->addColumn([
            'index'    => 'website',
            'label'    => trans('admin::app.datagrid.website'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                $url = $row->website;

                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                    $url = "http://" . $url;
                }

                return $url ? ("<a href='$url' target='_blank'>" . substr($url, 0, 15) . "...</a>") : '-';
            }
        ]);

        $this->addColumn([
            'index'    => 'size_range',
            'label'    => trans('admin::app.datagrid.size'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return $row->size_range;
            }
        ]);

        $this->addColumn([
            'index'      => 'persons_count',
            'label'      => trans('admin::app.datagrid.persons_count'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                $personsCount = $this->personRepository->findWhere(['organization_id' => $row->id])->count();

                $route = urldecode(route('persons.index', ['organization[in]' => $row->id]));

                return "<a href='" . $route . "'>" . $personsCount . "</a>";
            },
        ]);

        $this->addColumn([
            'index'    => 'formatted_phone_number',
            'label'    => trans('admin::app.datagrid.phone'),
            'type'     => 'string',
            'sortable' => true,
            'closure'  => function ($row) {
                return '<span class="blur-text">' . '+48 284920291' . '</span>';
            }
        ]);

    }

    /**
     * Prepare tab filters.
     *
     * @return array
     */
    public function prepareTabFilters()
    {
        $values = [
            [
                'name' => 'All'
            ],
            [
                'name' => 'Venture capital'
            ],
            [
                'name' => 'Software house'
            ],
            [
                'name' => 'Model agency'
            ],
        ];

        $this->addTabFilter([
            'key'        => 'types',
            'type'       => 'pill',
            'condition'  => 'eq',
            'value_type' => 'lookup',
            'values'     => $values,
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
            'title'       => trans('ui::app.datagrid.view'),
            'method'      => 'GET',
            'route'       => 'organizations.view',
            'icon'        => 'eye-icon',
            // 'description' => 'Buy now'
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
            'type'   => 'create',
            'label'  => trans('ui::app.datagrid.buy-mass'),
            'action' => route('organizations.mass_buy'),
            'method' => 'PUT',
        ]);
    }
}
