<?php

return [
    [
        'key'        => 'dashboard',
        'name'       => 'admin::app.layouts.dashboard',
        'route'      => 'dashboard.index',
        'sort'       => 1,
        'icon-class' => 'bi-view-list',
    ],
    // [
    //     'key'        => 'recommendations',
    //     'name'       => 'admin::app.layouts.recommendations',
    //     'route'      => 'recommendations.index',
    //     'sort'       => 3,
    //     'icon-class' => 'bi-star',
    // ], 
    /**
     * Search views
     */
    [
        'key'        => 'search',
        'name'       => 'admin::app.layouts.search',
        'route'      => 'search.index',
        'sort'       => 4,
        'class'      => 'bg-gold',
        'icon-class' => 'bi-binoculars',
    ], [
        'key'        => 'search.database',
        'name'       => 'admin::app.layouts.database',
        'info'       => 'admin::app.layouts.database-info',
        'route'      => 'organizations.index',
        'sort'       => 1,
        'icon-class' => 'bi-file-bar-graph',
    ], [
        'key'        => 'search.database.organizations',
        'name'       => 'admin::app.layouts.database-title',
        'info'       => 'admin::app.layouts.database-info',
        'route'      => 'organizations.index',
        'sort'       => 1,
        'icon-class' => 'bi-file-bar-graph',
    ], [
        'key'        => 'search.database.people',
        'name'       => 'admin::app.layouts.people-title',
        'info'       => 'admin::app.layouts.database-info',
        'route'      => 'employees.index',
        'sort'       => 2,
        'icon-class' => 'bi-people',
    ], [
        'key'        => 'search.location',
        'name'       => 'admin::app.layouts.search-title',
        'info'       => 'admin::app.layouts.search-info',
        'tooltip'    => 'The search engine allows you to find all contact addresses using a single specified domain name (for example, "konstelacja.co") and appearing publicly somewhere on the Web.',
        'route'      => 'search.location.index',
        'sort'       => 2,
        'icon-class' => 'bi-compass',
    ], [
        'key'        => 'search.location.text',
        'name'       => 'admin::app.layouts.location',
        'info'       => 'admin::app.layouts.location-info',
        'route'      => 'search.location.index',
        'sort'       => 1,
        'icon-class' => 'bi-compass',
    ], [
        'key'        => 'search.location.websites',
        'name'       => 'admin::app.layouts.websites',
        'info'       => 'admin::app.layouts.websites-info',
        'route'      => 'search.websites.index',
        'sort'       => 2,
        'icon-class' => 'bi-diagram-2',
        'free'       => true
    ], [
        'key'        => 'search.location.phones',
        'name'       => 'admin::app.layouts.phone-numbers',
        'info'       => 'admin::app.layouts.phone-numbers-info',
        'route'      => 'search.phones.index',
        'sort'       => 2,
        'icon-class' => 'bi-phone',
    ], [
        'key'        => 'search.analyze',
        'name'       => 'admin::app.layouts.analyze',
        'info'       => 'admin::app.layouts.analyze-info',
        'route'      => 'analyze.email.create',
        'sort'       => 3,
        'icon-class' => 'bi-diagram-2',
    ], [
        'key'        => 'search.analyze.email',
        'name'       => 'admin::app.layouts.email',
        'info'       => 'admin::app.layouts.analyze-email-info',
        'route'      => 'analyze.email.create',
        'sort'       => 3,
        'icon-class' => 'bi-envelope-check',
        'free'       => true
    ],  [
        'key'        => 'search.analyze.website',
        'name'       => 'admin::app.layouts.website',
        'info'       => 'admin::app.layouts.analyze-website-info',
        'route'      => 'analyze.website.create',
        'sort'       => 3,
        'icon-class' => 'bi-file-medical',
        'free'       => true
    ], [
        'key'        => 'search.analyze.phone',
        'name'       => 'admin::app.layouts.phone',
        'info'       => 'admin::app.layouts.analyze-phone-info',
        'route'      => 'analyze.phone.create',
        'sort'       => 3,
        'icon-class' => 'bi-telephone',
    ],
    [
        'key'        => 'results',
        'name'       => 'admin::app.layouts.results',
        'route'      => 'results.index',
        'sort'       => 4,
        'class'      => 'bg-gold',
        'icon-class' => 'bi-list-stars',
    ],
    /*
    |--------------------------------------------------------------------------
    | CRM
    |--------------------------------------------------------------------------
    |
    | All ACLs related to CRM will be placed here.
    |
    */
    [
        'key'        => 'crm',
        'name'       => 'admin::app.layouts.crm',
        'route'      => 'leads.index',
        'sort'       => 6,
        'icon-class' => 'bi-funnel',
    ], [
        'key'        => 'crm.leads',
        'name'       => 'admin::app.layouts.leads',
        'route'      => 'leads.index',
        'sort'       => 1,
        'icon-class' => 'bi-funnel',
    ], [
        'key'        => 'crm.quotes',
        'name'       => 'admin::app.layouts.quotes',
        'route'      => 'quotes.index',
        'sort'       => 2,
        'icon-class' => 'bi-chat-square-quote',
    ], [
        'key'        => 'crm.activities',
        'name'       => 'admin::app.layouts.activities',
        'route'      => 'activities.index',
        'sort'       => 5,
        'icon-class' => 'bi-activity',
    ], [
        'key'        => 'crm.products',
        'name'       => 'admin::app.layouts.products',
        'route'      => 'products.index',
        'sort'       => 7,
        'icon-class' => 'bi-bag',
    ],
    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    |
    | All ACLs related to mail will be placed here.
    |
    */
    [
        'key'        => 'mail',
        'name'       => 'admin::app.layouts.mail.title',
        'route'      => 'mail.index',
        'params'     => ['route' => 'inbox'],
        'sort'       => 7,
        'icon-class' => 'bi-mailbox',
    ], [
        'key'        => 'mail.compose',
        'name'       => 'admin::app.layouts.mail.compose',
        'route'      => 'mail.index',
        'params'     => ['route' => 'compose'],
        'sort'       => 1,
    ], [
        'key'        => 'mail.inbox',
        'name'       => 'admin::app.layouts.mail.inbox',
        'route'      => 'mail.index',
        'params'     => ['route' => 'inbox'],
        'sort'       => 2,
    ], [
        'key'        => 'mail.draft',
        'name'       => 'admin::app.layouts.mail.draft',
        'route'      => 'mail.index',
        'params'     => ['route' => 'draft'],
        'sort'       => 3,
    ], [
        'key'        => 'mail.outbox',
        'name'       => 'admin::app.layouts.mail.outbox',
        'route'      => 'mail.index',
        'params'     => ['route' => 'outbox'],
        'sort'       => 4,
    ], [
        'key'        => 'mail.sent',
        'name'       => 'admin::app.layouts.mail.sent',
        'route'      => 'mail.index',
        'params'     => ['route' => 'sent'],
        'sort'       => 4,
    ], [
        'key'        => 'mail.trash',
        'name'       => 'admin::app.layouts.mail.trash',
        'route'      => 'mail.index',
        'params'     => ['route' => 'trash'],
        'sort'       => 5,
    ], [
        'key'        => 'mail.setting',
        'name'       => 'admin::app.layouts.mail.setting',
        'route'      => 'mail.index',
        'params'     => ['route' => 'setting'],
        'sort'       => 5,
    ],
    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    |
    | All ACLs related to payments will be placed here.
    |
    */
    // [
    //     'key'        => 'payments',
    //     'name'       => 'admin::app.layouts.payments',
    //     'route'      => 'payments.index',
    //     'sort'       => 8,
    //     'icon-class' => 'bi-wallet',
    // ], 
    [
        'key'        => 'sales',
        'name'       => 'admin::app.layouts.payments',
        'route'      => 'sales.orders.index',
        'sort'       => 8,
        'icon-class' => 'bi-wallet',
    ], [
        'key'        => 'sales.orders',
        'name'       => 'admin::app.layouts.orders',
        'route'      => 'sales.orders.index',
        'sort'       => 1,
        'icon-class' => '',
    ], [
        'key'        => 'sales.invoices',
        'name'       => 'admin::app.layouts.invoices',
        'route'      => 'sales.invoices.index',
        'sort'       => 3,
        'icon-class' => '',
    ], [
        'key'        => 'sales.refunds',
        'name'       => 'admin::app.layouts.refunds',
        'route'      => 'sales.refunds.index',
        'sort'       => 4,
        'icon-class' => '',
    ], [
        'key'        => 'sales.transactions',
        'name'       => 'admin::app.layouts.transactions',
        'route'      => 'sales.transactions.index',
        'sort'       => 5,
        'icon-class' => '',
    ],
    [
        'key'        => 'cms',
        'name'       => 'admin::app.layouts.cms',
        'route'      => 'cms.pages.index',
        'sort'       => 9,
        'icon-class' => 'bi-journal-text',
    ], [
        'key'        => 'cms.pages',
        'name'       => 'admin::app.layouts.pages',
        'route'      => 'cms.pages.index',
        'sort'       => 1,
        'icon-class' => '',
    ],[
        'key'        => 'cms.blogs',
        'name'       => 'admin::app.layouts.blogs',
        'route'      => 'cms.blogs.index',
        'sort'       => 2,
        'icon-class' => '',
    ],
    [
        'key'        => 'settings',
        'name'       => 'admin::app.layouts.settings',
        'route'      => 'settings.index',
        'sort'       => 10,
        'icon-class' => 'bi-gear',
    ], [
        'key'        => 'settings.search',
        'name'       => 'admin::app.layouts.search',
        'info'       => 'admin::app.layouts.search-info',
        'route'      => 'settings.tags.index',
        'sort'       => 0,
        'icon-class' => 'settings-icon',
    ], [
        'key'        => 'settings.search.populations',
        'name'       => 'admin::app.layouts.populations',
        'info'       => 'admin::app.layouts.populations-info',
        'route'      => 'settings.populations.index',
        'sort'       => 2,
        'icon-class' => 'bi-geo',
    ], [
        'key'        => 'settings.search.types',
        'name'       => 'admin::app.layouts.types',
        'info'       => 'admin::app.layouts.types-info',
        'route'      => 'settings.search.types.index',
        'sort'       => 3,
        'icon-class' => 'bi-vector-pen',
    ], [
        'key'        => 'settings.user',
        'name'       => 'admin::app.layouts.user',
        'route'      => 'settings.groups.index',
        'info'       => 'admin::app.layouts.user-info',
        'sort'       => 1,
    ], [
        'key'        => 'settings.user.groups',
        'name'       => 'admin::app.layouts.groups',
        'info'       => 'admin::app.layouts.groups-info',
        'route'      => 'settings.groups.index',
        'sort'       => 1,
        'icon-class' => 'bi-building',
    ], [
        'key'        => 'settings.user.roles',
        'name'       => 'admin::app.layouts.roles',
        'info'       => 'admin::app.layouts.roles-info',
        'route'      => 'settings.roles.index',
        'sort'       => 2,
        'icon-class' => 'bi-employee-check',
    ], [
        'key'        => 'settings.user.users',
        'name'       => 'admin::app.layouts.users',
        'info'       => 'admin::app.layouts.users-info',
        'route'      => 'settings.users.index',
        'sort'       => 3,
        'icon-class' => 'bi-people',
    ], [
        'key'        => 'settings.lead',
        'name'       => 'admin::app.layouts.lead',
        'info'       => 'admin::app.layouts.lead-info',
        'route'      => 'settings.pipelines.index',
        'sort'       => 2,
    ], [
        'key'        => 'settings.lead.pipelines',
        'name'       => 'admin::app.layouts.pipelines',
        'info'       => 'admin::app.layouts.pipelines-info',
        'route'      => 'settings.pipelines.index',
        'sort'       => 1,
        'icon-class' => 'bi-funnel',
    ], [
        'key'        => 'settings.lead.sources',
        'name'       => 'admin::app.layouts.sources',
        'info'       => 'admin::app.layouts.sources-info',
        'route'      => 'settings.sources.index',
        'sort'       => 2,
        'icon-class' => 'bi-toggles',
    ], [
        'key'        => 'settings.lead.types',
        'name'       => 'admin::app.layouts.types',
        'info'       => 'admin::app.layouts.types-info',
        'route'      => 'settings.types.index',
        'sort'       => 3,
        'icon-class' => 'bi-vector-pen',
    ], [
        'key'        => 'settings.automation',
        'name'       => 'admin::app.layouts.automation',
        'info'       => 'admin::app.layouts.automation-info',
        'route'      => 'settings.attributes.index',
        'sort'       => 3,
    ], [
        'key'        => 'settings.automation.attributes',
        'name'       => 'admin::app.layouts.attributes',
        'info'       => 'admin::app.layouts.attributes-info',
        'route'      => 'settings.attributes.index',
        'sort'       => 1,
        'icon-class' => 'bi-view-list',
    ], [
        'key'        => 'settings.automation.email_templates',
        'name'       => 'admin::app.layouts.email-templates',
        'info'       => 'admin::app.layouts.email-templates-info',
        'route'      => 'settings.email_templates.index',
        'sort'       => 2,
        'icon-class' => 'bi-postcard-heart',
    ], [
        'key'        => 'settings.automation.workflows',
        'name'       => 'admin::app.layouts.workflows',
        'info'       => 'admin::app.layouts.workflows-info',
        'route'      => 'settings.workflows.index',
        'sort'       => 3,
        'icon-class' => 'bi-kanban',
    ], [
        'key'        => 'settings.payments',
        'name'       => 'admin::app.layouts.payments',
        'info'       => 'admin::app.layouts.payments-info',
        'route'      => 'settings.plans.index',
        'sort'       => 4,
        'icon-class' => 'bi-wallet',
    ], [
        'key'        => 'settings.payments.plans',
        'name'       => 'admin::app.layouts.plans',
        'info'       => 'admin::app.layouts.plans-info',
        'route'      => 'settings.plans.index',
        'sort'       => 4,
        'icon-class' => 'bi-wallet'
    ], [
        'key'        => 'settings.other_settings',
        'name'       => 'admin::app.layouts.other-settings',
        'info'       => 'admin::app.layouts.other-settings-info',
        'route'      => 'settings.tags.index',
        'sort'       => 4,
        'icon-class' => 'settings-icon',
    ], [
        'key'        => 'settings.other_settings.tags',
        'name'       => 'admin::app.layouts.tags',
        'info'       => 'admin::app.layouts.tags-info',
        'route'      => 'settings.tags.index',
        'sort'       => 1,
        'icon-class' => 'bi-tags',
    ], [
        'key'        => 'settings.other_settings.reports',
        'name'       => 'admin::app.layouts.reports',
        'info'       => 'admin::app.layouts.reports-info',
        'route'      => 'settings.reports.index',
        'sort'       => 3,
        'icon-class' => 'bi-flag',
    ], [
        'key'        => 'configuration',
        'name'       => 'admin::app.layouts.configuration',
        'route'      => 'configuration.index',
        'sort'       => 11,
        'icon-class' => 'bi-sliders ',
    ], [
        'key'        => 'configuration.api',
        'name'       => 'admin::app.layouts.general',
        'info'       => 'admin::app.layouts.search-info',
        'route'      => 'configuration.index',
        'sort'       => 1,
        'icon-class' => 'tools-icon',
    ]
];