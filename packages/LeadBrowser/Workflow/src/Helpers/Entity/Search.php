<?php

namespace LeadBrowser\Workflow\Helpers\Entity;

use Illuminate\Support\Facades\Mail;
use LeadBrowser\Admin\Notifications\Common;
use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Activity\Repositories\ActivityRepository;
use LeadBrowser\Organization\Repositories\EmployeeRepository;
use LeadBrowser\Tag\Repositories\TagRepository;

class Search extends AbstractEntity
{
    /**
     * @var string  $code
     */
    protected $entityType = 'search_locations';

    /**
     * AttributeRepository object
     *
     * @var \LeadBrowser\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * EmailTemplateRepository object
     *
     * @var \LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository
     */
    protected $emailTemplateRepository;

    /**
     * LeadRepository object
     *
     * @var \LeadBrowser\Lead\Repositories\LeadRepository
     */
    protected $leadRepository;

    /**
     * ActivityRepository object
     *
     * @var \LeadBrowser\Activity\Repositories\ActivityRepository
     */
    protected $activityRepository;

    /**
     * EmployeeRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * TagRepository object
     *
     * @var \LeadBrowser\Tag\Repositories\TagRepository
     */
    protected $tagRepository;

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository  $emailTemplateRepository
     * @param  \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @param \LeadBrowser\Activity\Repositories\ActivityRepository  $activityRepository
     * @param \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * @param  \LeadBrowser\Tag\Repositories\TagRepository  $tagRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository,
        LeadRepository $leadRepository,
        ActivityRepository $activityRepository,
        EmployeeRepository $employeeRepository,
        TagRepository $tagRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->leadRepository = $leadRepository;

        $this->activityRepository = $activityRepository;

        $this->employeeRepository = $employeeRepository;

        $this->tagRepository = $tagRepository;
    }

    /**
     * Returns entity
     * 
     * @param  \LeadBrowser\Lead\Contracts\Lead|integer  $entity
     * @return \LeadBrowser\Lead\Contracts\Lead
     */
    public function getEntity($entity)
    {
        if (! $entity instanceof \LeadBrowser\Lead\Contracts\Lead) {
            $entity = $this->leadRepository->find($entity);
        }

        return $entity;
    }

    /**
     * Returns workflow actions
     * 
     * @return array
     */
    public function getActions()
    {
        $emailTemplates = $this->emailTemplateRepository->all(['id', 'name']);

        return [
            [
                'id'         => 'update_lead',
                'name'       => __('admin::app.settings.workflows.update-lead'),
                'attributes' => $this->getAttributes('leads'),
            ], [
                'id'         => 'update_employee',
                'name'       => __('admin::app.settings.workflows.update-employee'),
                'attributes' => $this->getAttributes('employees'),
            ], [
                'id'      => 'send_email_to_employee',
                'name'    => __('admin::app.settings.workflows.send-email-to-employee'),
                'options' => $emailTemplates,
            ], [
                'id'      => 'send_email_to_sales_owner',
                'name'    => __('admin::app.settings.workflows.send-email-to-sales-owner'),
                'options' => $emailTemplates,
            ], [
                'id'   => 'add_tag',
                'name' => __('admin::app.settings.workflows.add-tag'),
            ], [
                'id'   => 'add_note_as_activity',
                'name' => __('admin::app.settings.workflows.add-note-as-activity'),
            ],
        ];
    }

    /**
     * Execute workflow actions
     * 
     * @param  \LeadBrowser\Workflow\Contracts\Workflow  $workflow
     * @param  \LeadBrowser\Lead\Contracts\Lead  $lead
     * @return array
     */
    public function executeActions($workflow, $lead)
    {
        
    }
}