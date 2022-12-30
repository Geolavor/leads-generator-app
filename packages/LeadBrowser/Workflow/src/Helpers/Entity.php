<?php

namespace LeadBrowser\Workflow\Helpers;

use LeadBrowser\Attribute\Repositories\AttributeRepository;
use LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository;

class Entity
{
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
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \LeadBrowser\EmailTemplate\Repositories\EmailTemplateRepository  $emailTemplateRepository
     * @param  \LeadBrowser\Lead\Repositories\LeadRepository  $leadRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        EmailTemplateRepository $emailTemplateRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * Returns events to match for the entity
     * 
     * @return array
     */
    public function getEvents()
    {
        $entities = config('workflows.trigger_entities');

        $events = [];

        foreach ($entities as $key => $entity) {
            $object = app($entity['class']);

            $events[$key] = [
                'id'     => $key,
                'name'   => $entity['name'],
                'events' => $entity['events'],
            ];
        }

        return $events;
    }

    /**
     * Returns conditions to match for the entity
     * 
     * @return array
     */
    public function getConditions()
    {
        $entities = config('workflows.trigger_entities');

        $conditions = [];

        foreach ($entities as $key => $entity) {
            $object = app($entity['class']);

            $conditions[$key] = $object->getConditions();
        }

        return $conditions;
    }

    /**
     * Returns workflow actions
     * 
     * @return array
     */
    public function getActions()
    {
        $entities = config('workflows.trigger_entities');

        $conditions = [];

        foreach ($entities as $key => $entity) {
            $object = app($entity['class']);

            $conditions[$key] = $object->getActions();
        }

        return $conditions;
    }

    /**
     * Returns placeholders for email templates
     * 
     * @return array
     */
    public function getEmailTemplatePlaceholders()
    {
        $entities = config('workflows.trigger_entities');

        $placeholders = [];

        foreach ($entities as $key => $entity) {
            $object = app($entity['class']);

            $placeholders[] = $object->getEmailTemplatePlaceholders($entity);
        }

        return $placeholders;
    }
}