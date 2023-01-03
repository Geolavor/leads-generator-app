<?php

namespace LeadBrowser\Workflow\Helpers\Entity;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use LeadBrowser\Admin\Notifications\Common;
use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;
use LeadBrowser\Lead\Repositories\LeadRepository;
use LeadBrowser\Organization\Repositories\EmployeeRepository;
use LeadBrowser\Activity\Repositories\ActivityRepository;

class Activity extends AbstractEntity
{
    /**
     * @var string  $code
     */
    protected $entityType = 'activities';

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
     * ActivityRepository object
     *
     * @var \LeadBrowser\Activity\Repositories\ActivityRepository
     */
    protected $activityRepository;

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
     * @param \LeadBrowser\Activity\Repositories\ActivityRepository  $activityRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository,
        LeadRepository $leadRepository,
        EmployeeRepository $employeeRepository,
        ActivityRepository $activityRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->leadRepository = $leadRepository;

        $this->employeeRepository = $employeeRepository;

        $this->activityRepository = $activityRepository;
    }

    /**
     * Returns attributes
     *
     * @param  string  $entityType
     * @param  array  $skipAttributes
     * @return array
     */
    public function getAttributes($entityType, $skipAttributes = [])
    {
        $attributes = [
            [
                'id'          => 'title',
                'type'        => 'text',
                'name'        => 'Title',
                'lookup_type' => null,
                'options'     => collect([]),
            ], [
                'id'          => 'type',
                'type'        => 'multiselect',
                'name'        => 'Type',
                'lookup_type' => null,
                'options'     => collect([
                    (object) [
                        'id'   => 'note',
                        'name' => 'Note',
                    ], (object) [
                        'id'   => 'call',
                        'name' => 'Call',
                    ], (object) [
                        'id'   => 'meeting',
                        'name' => 'Meeting',
                    ], (object) [
                        'id'   => 'lunch',
                        'name' => 'Lunch',
                    ], (object) [
                        'id'   => 'file',
                        'name' => 'File',
                    ],
                ]),
            ], [
                'id'          => 'location',
                'type'        => 'text',
                'name'        => 'Location',
                'lookup_type' => null,
                'options'     => collect([]),
            ], [
                'id'          => 'comment',
                'type'        => 'textarea',
                'name'        => 'Comment',
                'lookup_type' => null,
                'options'     => collect([]),
            ], [
                'id'          => 'schedule_from',
                'type'        => 'datetime',
                'name'        => 'Schedule From',
                'lookup_type' => null,
                'options'     => collect([]),
            ], [ 
                'id'          => 'schedule_to',
                'type'        => 'datetime',
                'name'        => 'Schedule To',
                'lookup_type' => null,
                'options'     => collect([]),
            ], [
                'id'          => 'user_id',
                'type'        => 'select',
                'name'        => 'User',
                'lookup_type' => 'users',
                'options'     => $this->attributeRepository->getLookUpOptions('users'),
            ], [
                'id'          => 'is_done',
                'type'        => 'boolean',
                'name'        => 'Is done',
                'lookup_type' => null,
                'options'     => collect([]),
            ]
        ];

        return $attributes;
    }

    /**
     * Returns placeholders for email templates
     * 
     * @param  array  $entity
     * @return array
     */
    public function getEmailTemplatePlaceholders($entity)
    {
        $emailTemplates = parent::getEmailTemplatePlaceholders($entity);

        $emailTemplates['menu'][] = [
            'text'  => 'Participants',
            'value' => '{%activities.participants%}'
        ];

        return $emailTemplates;
    }

    /**
     * Replace placeholders with values
     * 
     * @param  array  $entity
     * @param  array  $values
     * @return string
     */
    public function replacePlaceholders($entity, $content)
    {
        $content = parent::replacePlaceholders($entity, $content);

        $value = '<ul style="padding-left: 18px;margin: 0;">';

        foreach ($entity->participants as $participant) {
            $value .= '<li>' . ($participant->user ? $participant->user->name : $participant->employee->name) . '</li>';
        }

        $value .= '</ul>';

        $content = strtr($content, [
            '{%' . $this->entityType . '.participants%}'   => $value,
            '{% ' . $this->entityType . '.participants %}' => $value,
        ]);

        return $content;
    }

    /**
     * Returns entity
     * 
     * @param  \LeadBrowser\Activity\Contracts\Activity|integer  $entity
     * @return \LeadBrowser\Activity\Contracts\Activity
     */
    public function getEntity($entity)
    {
        if (! $entity instanceof \LeadBrowser\Activity\Contracts\Activity) {
            $entity = $this->activityRepository->find($entity);
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
                'id'         => 'update_related_leads',
                'name'       => __('admin::app.settings.workflows.update-related-leads'),
                'attributes' => parent::getAttributes('leads'),
            ], [
                'id'      => 'send_email_to_sales_owner',
                'name'    => __('admin::app.settings.workflows.send-email-to-sales-owner'),
                'options' => $emailTemplates,
            ], [
                'id'      => 'send_email_to_participants',
                'name'    => __('admin::app.settings.workflows.send-email-to-participants'),
                'options' => $emailTemplates,
            ],
        ];
    }

    /**
     * Execute workflow actions
     * 
     * @param  \LeadBrowser\Workflow\Contracts\Workflow  $workflow
     * @param  \LeadBrowser\Activity\Contracts\Activity  $activity
     * @return array
     */
    public function executeActions($workflow, $activity)
    {
        foreach ($workflow->actions as $action) {
            switch ($action['id']) {
                case 'update_related_leads':
                    $leadIds = $this->activityRepository->getModel()
                        ->leftJoin('lead_activities', 'activities.id', 'lead_activities.activity_id')
                        ->leftJoin('leads', 'lead_activities.lead_id', 'leads.id')
                        ->addSelect('leads.id')
                        ->where('activities.id', $activity->id)
                        ->pluck('id');

                    foreach ($leadIds as $leadId) {
                        $this->leadRepository->update([
                            'entity_type'        => 'leads',
                            $action['attribute'] => $action['value'],
                        ], $leadId);
                    }

                    break;

                case 'send_email_to_sales_owner':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        Mail::queue(new Common([
                            'to'          => $activity->user->email,
                            'subject'     => $this->replacePlaceholders($activity, $emailTemplate->subject),
                            'body'        => $this->replacePlaceholders($activity, $emailTemplate->content),
                            'attachments' => [
                                [
                                    'name'    => 'invite.ics',
                                    'mime'    => 'text/calendar',
                                    'content' => $this->getICSContent($activity),
                                ],
                            ],
                        ]));
                    } catch (\Exception $e) {}

                    break;

                case 'send_email_to_participants':
                    $emailTemplate = $this->emailTemplateRepository->find($action['value']);

                    if (! $emailTemplate) {
                        break;
                    }

                    try {
                        foreach ($activity->participants as $participant) {
                            Mail::queue(new Common([
                                'to'          => $participant->user
                                                ? $participant->user->email
                                                : data_get($participant->employee->emails, '*.value'),
                                'subject'     => $this->replacePlaceholders($activity, $emailTemplate->subject),
                                'body'        => $this->replacePlaceholders($activity, $emailTemplate->content),
                                'attachments' => [
                                    [
                                        'name'    => 'invite.ics',
                                        'mime'    => 'text/calendar',
                                        'content' => $this->getICSContent($activity),
                                    ],
                                ],
                            ]));
                        }
                    } catch (\Exception $e) {}

                    break;
            }
        }
    }

    /**
     * Returns .ics file for attachments
     * 
     * @param  \LeadBrowser\Activity\Contracts\Activity  $activity
     * @return string
     */
    public function getICSContent($activity)
    {
        $content = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//LeadBrowsercrm//LeadBrowsercrm//EN',
            'BEGIN:VEVENT',
            'UID:' . time() . '-' . $activity->id,
            'DTSTAMP:' . Carbon::now()->format('YmdTHis'),
            'CREATED:' . $activity->created_at->format('YmdTHis'),
            'SEQUENCE:1',
            'ORGANIZER;CN=' . $activity->user->name . ':MAILTO:' . $activity->user->email,
        ];

        foreach ($activity->participants as $participant) {
            $emails = $participant->user
                ? [$participant->user->email]
                : data_get($participant->employee->emails, '*.value');

            if ($participant->user) {
                $content[] = 'ATTENDEE;ROLE=REQ-PARTICIPANT;CN=' . $participant->user->name . ';PARTSTAT=NEEDS-ACTION:MAILTO:' . $participant->user->email;
            } else {
                foreach (data_get($participant->employee->emails, '*.value') as $email) {
                    $content[] = 'ATTENDEE;ROLE=REQ-PARTICIPANT;CN=' . $participant->employee->name . ';PARTSTAT=NEEDS-ACTION:MAILTO:' . $email;
                }
            }
        }

        $content = array_merge($content, [
            'DTSTART:' . $activity->schedule_from->format('YmdTHis'),
            'DTEND:' . $activity->schedule_to->format('YmdTHis'),
            'SUMMARY:' . $activity->title,
            'LOCATION:' . $activity->location,
            'DESCRIPTION:' . $activity->comment,
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        return implode("\r\n", $content);
    }
}