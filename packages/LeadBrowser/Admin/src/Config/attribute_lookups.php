<?php

return [
    'leads' => [
        'name'         => 'Leads',
        'repository'   => 'LeadBrowser\Lead\Repositories\LeadRepository',
        'label_column' => 'title',
    ],

    'lead_sources' => [
        'name'         => 'Lead Sources',
        'repository'   => 'LeadBrowser\Lead\Repositories\SourceRepository',
    ],

    'lead_types' => [
        'name'         => 'Lead Types',
        'repository'   => 'LeadBrowser\Lead\Repositories\TypeRepository',
    ],

    'lead_pipelines' => [
        'name'         => 'Lead Pipelines',
        'repository'   => 'LeadBrowser\Lead\Repositories\PipelineRepository',
    ],

    'lead_pipeline_stages' => [
        'name'         => 'Lead Pipeline Stages',
        'repository'   => 'LeadBrowser\Lead\Repositories\StageRepository',
    ],

    'users' => [
        'name'         => 'Sales Owners',
        'repository'   => 'LeadBrowser\User\Repositories\UserRepository',
    ],

    'organizations' => [
        'name'         => 'Organizations',
        'repository'   => 'LeadBrowser\Organization\Repositories\OrganizationRepository',
    ],

    'employees' => [
        'name'         => 'Employees',
        'repository'   => 'LeadBrowser\Organization\Repositories\EmployeeRepository',
    ],

    'countries' => [
        'name'         => 'Countries',
        'repository'   => 'LeadBrowser\Core\Repositories\CountryRepository',
    ],

    'states' => [
        'name'         => 'States',
        'repository'   => 'LeadBrowser\Core\Repositories\StateRepository',
    ],

    'population_sources' => [
        'name'         => 'Population Sources',
        'repository'   => 'LeadBrowser\Core\Repositories\PopulationRepository',
    ],

    'search_types' => [
        'name'         => 'Search Types',
        'repository'   => 'LeadBrowser\Search\Repositories\SearchTypeRepository',
    ],
];