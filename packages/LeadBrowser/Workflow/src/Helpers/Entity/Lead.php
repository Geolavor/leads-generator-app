<?php

namespace LeadBrowser\Workflow\Helpers\Entity;

use Illuminate\Support\Facades\Mail;
use LeadBrowser\Admin\Notifications\Common;
use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Activity\Repositories\ActivityRepository;
use LeadBrowser\Organization\Repositories\PersonRepository;
use LeadBrowser\Tag\Repositories\TagRepository;

class Lead extends AbstractEntity
{
    /**
     * @var string  $code
     */
    protected $entityType = 'leads';

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
     * PersonRepository object
     *
     * @var \LeadBrowser\Organization\Repositories\PersonRepository
     */
    protected $personRepository;

    /**
     * TagRepository object
     *
     * @var \LeadBrowser\Tag\Repositories\TagRepository
     */
    protected $tagRepository;

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
     * @param \LeadBrowser\Activity\Repositories\ActivityRepository  $activityRepository
     * @param \LeadBrowser\Organization\Repositories\PersonRepository  $personRepository
     * @param  \LeadBrowser\Tag\Repositories\TagRepository  $tagRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository,
        LeadRepository $leadRepository,
        ActivityRepository $activityRepository,
        PersonRepository $personRepository,
        TagRepository $tagRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->leadRepository = $leadRepository;

        $this->activityRepository = $activityRepository;

        $this->personRepository = $personRepository;

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
     * Returns attributes
     *
     * @param  string  $entityType
     * @param  array  $skipAttributes
     * @return array
     */
    public function getAttributes($entityType, $skipAttributes = ['textarea', 'image', 'file', 'address'])
    {
        $attributes[] = [
            'id'          => 'lead_pipeline_stage_id',
            'type'        => 'select',
            'name'        => 'Stage',
            'lookup_type' => 'lead_pipeline_stages',
            'options'     => collect([]),
        ];

        return array_merge(
            parent::getAttributes($entityType, $skipAttributes),
            $attributes
        );
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
                'id'         => 'update_person',
                'name'       => __('admin::app.settings.workflows.update-person'),
                'attributes' => $this->getAttributes('persons'),
            ], [
                'id'      => 'send_email_to_person',
                'name'    => __('admin::app.settings.workflows.send-email-to-person'),
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
        foreach ($workflow->actions as $action) {
            switch ($action['id']) {
                case 'update_lead':
                    $this->leadRepository->update([
                        'entity_type'        => 'leads',
                        $action['attribute'] => $action['value'],
                    ], $lead->id);

                    break;

                case 'update_person':
                    $this->personRepository->update([
                        'entity_type'        => 'persons',
                        $action['attribute'] => $action['value'],
                    ], $lead->person_id);

                    break;
                    
                case 'send_email_to_person':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        Mail::queue(new Common([
                            'to'      => data_get($lead->person->emails, '*.value'),
                            'subject' => $this->replacePlaceholders($lead, $emailTemplate->subject),
                            'body'    => $this->replacePlaceholders($lead, $emailTemplate->content),
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
                            'to'      => $lead->user->email,
                            'subject' => $this->replacePlaceholders($lead, $emailTemplate->subject),
                            'body'    => $this->replacePlaceholders($lead, $emailTemplate->content),
                        ]));
                    } catch (\Exception $e) {}

                    break;
            
                case 'add_tag':
                    $colors = [
                        '#337CFF',
                        '#FEBF00',
                        '#E5549F',
                        '#27B6BB',
                        '#FB8A3F',
                        '#43AF52'
                    ];

                    if (! $tag = $this->tagRepository->findOneByField('name', $action['value'])) {
                        $tag = $this->tagRepository->create([
                            'name'    => $action['value'],
                            'color'   => $colors[rand(0, 5)],
                            'user_id' => auth()->guard('user')->user()->id,
                        ]);
                    }

                    if (! $lead->tags->contains($tag->id)) {
                        $lead->tags()->attach($tag->id);
                    }

                    break;
            
                case 'add_note_as_activity':
                    $activity = $this->activityRepository->create([
                        'type'    => 'note',
                        'comment' => $action['value'],
                        'is_done' => 1,
                        'user_id' => $userId = auth()->guard('user')->user()->id,
                    ]);

                    $lead->activities()->attach($activity->id);
                    
                    break;
            }    
        }
    }
}