<?php

namespace LeadBrowser\Lead\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Organization\Repositories\EmployeeRepository;
use LeadBrowser\Attribute\Repositories\AttributeValueRepository;

class LeadRepository extends Repository
{
    /**
     * StageRepository object
     *
     * @var \LeadBrowser\Lead\Repositories\StageRepository
     */
    protected $stageRepository;

    /**
     * EmployeeRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * ProductRepository object
     *
     * @var \LeadBrowser\Lead\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * AttributeValueRepository object
     *
     * @var \LeadBrowser\Attribute\Repositories\AttributeValueRepository
     */
    protected $attributeValueRepository;

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Lead\Repositories\StageRepository  $stageRepository
     * @param  \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * @param  \LeadBrowser\Lead\Repositories\ProductRepository  $productRepository
     * @param  \LeadBrowser\Attribute\Repositories\AttributeValueRepository  $attributeValueRepository
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        StageRepository $stageRepository,
        EmployeeRepository $employeeRepository,
        ProductRepository $productRepository,
        AttributeValueRepository $attributeValueRepository,
        Container $container
    ) {
        $this->stageRepository = $stageRepository;

        $this->employeeRepository = $employeeRepository;

        $this->productRepository = $productRepository;

        $this->attributeValueRepository = $attributeValueRepository;

        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Lead\Contracts\Lead';
    }

    /**
     * @param  integer  $pipelineId
     * @param  string  $term
     * @param  string  $createdAtRange
     * @return \LeadBrowser\Lead\Contracts\Lead
     */
    public function getLeads($pipelineId, $term, $createdAtRange)
    {
        return $this
                ->select(
                    'leads.id as id',
                    'leads.created_at as created_at',
                    'title',
                    'lead_value',
                    'employees.name as employee_name',
                    'leads.employee_id as employee_id',
                    'lead_pipelines.id as lead_pipeline_id',
                    'lead_pipeline_stages.name as status',
                    'lead_pipeline_stages.id as lead_pipeline_stage_id'
                )
                ->addSelect(\DB::raw('DATEDIFF(leads.created_at + INTERVAL lead_pipelines.rotten_days DAY, now()) as rotten_days'))
                ->leftJoin('employees', 'leads.employee_id', '=', 'employees.id')
                ->leftJoin('lead_pipelines', 'leads.lead_pipeline_id', '=', 'lead_pipelines.id')
                ->leftJoin('lead_pipeline_stages', 'leads.lead_pipeline_stage_id', '=', 'lead_pipeline_stages.id')
                ->where("title", 'like', "%$term%")
                ->where("leads.lead_pipeline_id", $pipelineId)
                ->when($createdAtRange, function($query) use ($createdAtRange) {
                    return $query->whereBetween('leads.created_at', $createdAtRange);
                })
                ->where(function ($query) {
                    $currentUser = auth()->guard('user')->user();

                    if ($currentUser->view_permission != 'global') {
                        if ($currentUser->view_permission == 'group') {
                            $query->whereIn('leads.user_id', app('\LeadBrowser\User\Repositories\UserRepository')->getCurrentUserGroupsUserIds());
                        } else {
                            $query->where('leads.user_id', $currentUser->id);
                        }
                    }
                })
                ->get();
    }

    /**
     * @param array $data
     * @return \LeadBrowser\Lead\Contracts\Lead
     */
    public function create(array $data)
    {
        if (isset($data['employee']['id'])) {
            $employee = $this->employeeRepository->update(array_merge($data['employee'], [
                'entity_type' => 'employees',
            ]), $data['employee']['id']);
        } else {
            $employee = $this->employeeRepository->create(array_merge($data['employee'], [
                'entity_type' => 'employees',
            ]));
        }

        $stage = $this->stageRepository->find($data['lead_pipeline_stage_id']);

        $lead = parent::create(array_merge([
            'employee_id'              => $employee->id,
            'lead_pipeline_id'       => 1,
            'lead_pipeline_stage_id' => 1,
        ], $data));

        $this->attributeValueRepository->save($data, $lead->id);

        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $this->productRepository->create(array_merge($product, [
                    'lead_id' => $lead->id,
                    'amount'  => $product['price'] * $product['quantity'],
                ]));
            }
        }

        return $lead;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Lead\Contracts\Lead
     */
    public function update(array $data, $id, $attribute = "id")
    {
        if (isset($data['employee'])) {
            if (isset($data['employee']['id'])) {
                $employee = $this->employeeRepository->update(array_merge($data['employee'], [
                    'entity_type' => 'employees',
                ]), $data['employee']['id']);
            } else {
                $employee = $this->employeeRepository->create(array_merge($data['employee'], [
                    'entity_type' => 'employees',
                ]));
            }

            $data = array_merge([
                'employee_id' => $employee->id,
            ], $data);
        }

        if (isset($data['lead_pipeline_stage_id'])) {
            $stage = $this->stageRepository->find($data['lead_pipeline_stage_id']);

            if (in_array($stage->code, ['won', 'lost'])) {
                $data['closed_at'] = $data['closed_at'] ?? Carbon::now();
            } else {
                $data['closed_at'] = null;
            }
        }

        $lead = parent::update($data, $id);

        $this->attributeValueRepository->save($data, $id);

        if (! isset($data['_method'])) {
            return $lead;
        }

        $previousProductIds = $lead->products()->pluck('id');

        if (isset($data['products'])) {
            foreach ($data['products'] as $productId => $productInputs) {
                if (Str::contains($productId, 'product_')) {
                    $this->productRepository->create(array_merge([
                        'lead_id' => $lead->id,
                    ], $productInputs));
                } else {
                    if (is_numeric($index = $previousProductIds->search($productId))) {
                        $previousProductIds->forget($index);
                    }

                    $this->productRepository->update($productInputs, $productId);
                }
            }
        }

        foreach ($previousProductIds as $productId) {
            $this->productRepository->delete($productId);
        }

        return $lead;
    }

    /**
     * Retrieves lead count based on lead stage name
     *
     * @return number
     */
    public function getLeadsCount($leadStage, $startDate, $endDate)
    {
        $query = $this
            ->whereBetween('leads.created_at', [$startDate, $endDate])
            ->where(function ($query) {
                if (($currentUser = auth()->guard('user')->user())->view_permission == "individual") {
                    $query->where('leads.user_id', $currentUser->id);
                }
            });

        if ($leadStage != "all") {
            $query->leftJoin('lead_pipeline_stages', 'leads.lead_pipeline_stage_id', '=', 'lead_pipeline_stages.id')
                ->where('lead_pipeline_stages.name', $leadStage);
        }

        return $query->get()->count();
    }

    /**
     * Retrieves all lead's activities
     *
     * @param  integer  $id
     * @return mixed
     */
    public function getAllActivities($id)
    {
        $lead = $this->find($id);

        return array_values($lead->activities->concat($this->getFlattenEmails($id)->map(function ($item) {
            $item->is_done = 1;

            $item->type = 'email';

            $item->from =  Str::replaceFirst('"', '', Str::replaceLast('"', '', $item->from));

            $item->reply_to =  json_decode($item->reply_to);

            $item->folders =  json_decode($item->folders);

            $item->type = 'email';
            
            return $item;
        }))->sortBy('created_at')->toArray());
    }

    /**
     * Retrieves all lead's activities
     *
     * @param  integer  $leadId
     * @return mixed
     */
    public function getFlattenEmails($leadId)
    {
        return DB::table('emails as child')
            ->select('child.*')
            ->join('emails as parent', 'child.parent_id', '=', 'parent.id')
            ->where('parent.lead_id', $leadId)
            ->union(DB::table('emails as parent')->where('parent.lead_id', $leadId))
            ->get();
    }
}