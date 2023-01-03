<?php

namespace LeadBrowser\Workflow\Helpers\Entity;

use Illuminate\Support\Facades\Mail;
use LeadBrowser\Admin\Notifications\Common;
use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;
use LeadBrowser\Quote\Repositories\QuoteRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Organization\Repositories\EmployeeRepository;

class Quote extends AbstractEntity
{
    /**
     * @var string  $code
     */
    protected $entityType = 'quotes';

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
     * QuoteRepository object
     *
     * @var \LeadBrowser\Quote\Repositories\QuoteRepository
     */
    protected $quoteRepository;

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
     * @param  \LeadBrowser\Quote\Repositories\QuoteRepository  $quoteRepository
     * @param \LeadBrowser\Organization\Repositories\EmployeeRepository  $employeeRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository,
        QuoteRepository $quoteRepository,
        LeadRepository $leadRepository,
        EmployeeRepository $employeeRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->quoteRepository = $quoteRepository;

        $this->leadRepository = $leadRepository;

        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Returns entity
     * 
     * @param  \LeadBrowser\Quote\Contracts\Quote|integer  $entity
     * @return \LeadBrowser\Quote\Contracts\Quote
     */
    public function getEntity($entity)
    {
        if (! $entity instanceof \LeadBrowser\Quote\Contracts\Quote) {
            $entity = $this->quoteRepository->find($entity);
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
                'id'         => 'update_quote',
                'name'       => __('admin::app.settings.workflows.update-quote'),
                'attributes' => $this->getAttributes('quotes'),
            ], [
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
            ], [
                'id'      => 'send_email_to_sales_owner',
                'name'    => __('admin::app.settings.workflows.send-email-to-sales-owner'),
                'options' => $emailTemplates,
            ],
        ];
    }

    /**
     * Execute workflow actions
     * 
     * @param  \LeadBrowser\Workflow\Contracts\Workflow  $workflow
     * @param  \LeadBrowser\Quote\Contracts\Quote  $quote
     * @return array
     */
    public function executeActions($workflow, $quote)
    {
        foreach ($workflow->actions as $action) {
            switch ($action['id']) {
                case 'update_quote':
                    $this->quoteRepository->update([
                        'entity_type'        => 'quotes',
                        $action['attribute'] => $action['value'],
                    ], $quote->id);

                    break;
                
                case 'update_employee':
                    $this->employeeRepository->update([
                        'entity_type'        => 'employees',
                        $action['attribute'] => $action['value'],
                    ], $quote->employee_id);

                    break;
                
                case 'update_related_leads':
                    foreach ($quote->leads as $lead) {
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
                            'to'      => data_get($quote->employee->emails, '*.value'),
                            'subject' => $this->replacePlaceholders($quote, $emailTemplate->subject),
                            'body'    => $this->replacePlaceholders($quote, $emailTemplate->content),
                        ]));
                    } catch (\Exception $e) {}

                    break;
            
                case 'send_email_to_sales_owner':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        Mail::queue(new Common([
                            'to'      => $quote->user->email,
                            'subject' => $this->replacePlaceholders($quote, $emailTemplate->subject),
                            'body'    => $this->replacePlaceholders($quote, $emailTemplate->content),
                        ]));
                    } catch (\Exception $e) {}

                    break;
            }
        }
    }
}