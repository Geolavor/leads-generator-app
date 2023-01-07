<?php

namespace LeadBrowser\Workflow\Helpers\Entity;

use Illuminate\Support\Facades\Mail;
use LeadBrowser\Admin\Notifications\Common;
use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Organization\Repositories\EmployeeRepository;

class Employee extends AbstractEntity
{
    /**
     * @var string  $code
     */
    protected $entityType = 'employees';

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
     * EmployeeRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\EmployeeRepository
     */
    protected $employeeRepository;

     /**
     * Attributes to be sorted
     * 
     * @var array  $attributesToBeSorted
     */
    protected $attributesToBeSorted = ['lead_pipeline_stages' => 'sort_order'];

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository  $emailTemplateRepository
     * @param  \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @param \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository,
        LeadRepository $leadRepository,
        EmployeeRepository $employeeRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->leadRepository = $leadRepository;

        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Returns entity
     * 
     * @param  \LeadBrowser\Organization\Contracts\Employee|integer  $entity
     * @return \LeadBrowser\Organization\Contracts\Employee
     */
    public function getEntity($entity)
    {
        if (! $entity instanceof \LeadBrowser\Organization\Contracts\Employee) {
            $entity = $this->employeeRepository->find($entity);
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
                'id'         => 'update_employee',
                'name'       => __('admin::app.settings.workflows.update-employee'),
                'attributes' => $this->getAttributes('employees'),
            ], [
                'id'         => 'update_related_leads',
                'name'       => __('admin::app.settings.workflows.update-related-leads'),
                'attributes' => $this->getAttributes('leads'),
            ], [
                'id'      => 'send_email_to_employee',
                'name'    => __('admin::app.settings.workflows.send-email-to-employee'),
                'options' => $emailTemplates,
            ],
        ];
    }

    /**
     * Execute workflow actions
     * 
     * @param  \LeadBrowser\Workflow\Contracts\Workflow  $workflow
     * @param  \LeadBrowser\Organization\Contracts\Employee  $employee
     * @return array
     */
    public function executeActions($workflow, $employee)
    {
        foreach ($workflow->actions as $action) {
            switch ($action['id']) {
                case 'update_employee':
                    $this->employeeRepository->update([
                        'entity_type'        => 'employees',
                        $action['attribute'] => $action['value'],
                    ], $employee->id);

                    break;

                case 'update_related_leads':
                    $leads = $this->leadRepository->findByField('employee_id', $employee->id);

                    foreach ($leads as $lead) {
                        $this->leadRepository->update([
                            'entity_type'        => 'leads',
                            $action['attribute'] => $action['value'],
                        ], $lead->id);
                    }

                    break;

                case 'send_email_to_employee':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        Mail::queue(new Common([
                            'to'      => data_get($employee->emails, '*.value'),
                            'subject' => $this->replacePlaceholders($employee, $emailTemplate->subject),
                            'body'    => $this->replacePlaceholders($employee, $emailTemplate->content),
                        ]));
                    } catch (\Exception $e) {}

                    break;
            }
        }
    }
}