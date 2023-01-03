<?php

return [
    [
        'key'   => 'dashboard',
        'name'  => 'admin::app.layouts.dashboard',
        'route' => 'dashboard.index',
        'sort'  => 1,
    ],
    [
        'key'   => 'recommendations',
        'name'  => 'admin::app.layouts.recommendations',
        'route' => 'recommendations.index',
        'sort'  => 2,
    ],
    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | All ACLs related to search will be placed here.
    |
    */
    [
        'key'   => 'search',
        'name'  => 'admin::app.acl.search',
        'route' => 'search.index',
        'sort'  => 2,
    ],
    /*
    |--------------------------------------------------------------------------
    | Organizations
    |--------------------------------------------------------------------------
    |
    | All ACLs related to organizations will be placed here.
    |
    */
    [
        'key'   => 'search.database',
        'name'  => 'admin::app.acl.organizations',
        'route' => 'organizations.index',
        'sort'  => 3,
    ], [
        'key'   => 'search.database.organizations',
        'name'  => 'admin::app.acl.organizations',
        'route' => 'organizations.index',
        'sort'  => 2,
    ], [
        'key'   => 'search.database.organizations.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'organizations.view',
        'sort'  => 2,
    ], [
        'key'   => 'search.database.organizations.export',
        'name'  => 'admin::app.acl.export',
        'route' => 'ui.datagrid.export',
        'sort'  => 4,
    ], [
        'key'   => 'search.database.organizations.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['organizations.create', 'organizations.store'],
        'sort'  => 1,
    ], [
        'key'   => 'search.database.organizations.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['organizations.edit', 'organizations.update'],
        'sort'  => 2,
    ], [
        'key'   => 'search.database.organizations.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['organizations.delete', 'organizations.mass_delete'],
        'sort'  => 3,
    ],
    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    |
    | All ACLs related to employees will be placed here.
    |
    */
    [
        'key'   => 'search.database.employees',
        'name'  => 'admin::app.acl.employees',
        'route' => 'employees.index',
        'sort'  => 3,
    ],  [
        'key'   => 'search.database.employees.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'employees.view',
        'sort'  => 2,
    ], [
        'key'   => 'search.database.employees.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['employees.create', 'employees.store'],
        'sort'  => 2,
    ], [
        'key'   => 'search.database.employees.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['employees.edit', 'employees.update'],
        'sort'  => 3,
    ], [
        'key'   => 'search.database.employees.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['employees.delete', 'employees.mass_delete'],
        'sort'  => 4,
    ], [
        'key'   => 'search.database.employees.export',
        'name'  => 'admin::app.acl.export',
        'route' => 'ui.datagrid.export',
        'sort'  => 4,
    ],
    
    [
        'key'   => 'search.location',
        'name'  => 'admin::app.acl.search',
        'route' => 'search.location.index',
        'sort'  => 2,
    ], [
        'key'   => 'search.location.text',
        'name'  => 'admin::app.acl.location',
        'route' => 'search.location.index',
        'sort'  => 2,
    ], [
        'key'   => 'search.location.text.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['search.location.create', 'search.location.store'],
        'sort'  => 1,
    ], [
        'key'   => 'search.location.text.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'search.location.view',
        'sort'  => 2,
    ], [
        'key'   => 'search.location.text.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['search.location.delete', 'search.location.mass_delete'],
        'sort'  => 4,
    ], [
        'key'   => 'search.location.websites',
        'name'  => 'admin::app.acl.website',
        'route' => 'search.websites.index',
        'sort'  => 2,
    ], [
        'key'   => 'search.location.websites.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['search.websites.create', 'search.websites.store'],
        'sort'  => 1,
    ], [
        'key'   => 'search.location.websites.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'search.websites.view',
        'sort'  => 2,
    ], [
        'key'   => 'search.location.websites.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['search.websites.delete', 'search.websites.mass_delete'],
        'sort'  => 4,
    ],
    
    [
        'key'   => 'search.analyze',
        'name'  => 'admin::app.acl.analyze',
        'route' => 'analyze.email.create',
        'sort'  => 3,
    ], [
        'key'   => 'search.analyze.email',
        'name'  => 'admin::app.acl.email',
        'route' => ['analyze.email.create', 'analyze.email.store'],
        'sort'  => 1,
    ], [
        'key'   => 'search.analyze.website',
        'name'  => 'admin::app.acl.website',
        'route' => ['analyze.website.create', 'analyze.website.store'],
        'sort'  => 1,
    ], [
        'key'   => 'search.analyze.phone',
        'name'  => 'admin::app.acl.phone',
        'route' => ['analyze.phone.create', 'analyze.phone.store'],
        'sort'  => 1,
    ],
    /*
    |--------------------------------------------------------------------------
    | Results
    |--------------------------------------------------------------------------
    |
    | All ACLs related to results will be placed here.
    |
    */
    [
        'key'   => 'results',
        'name'  => 'admin::app.acl.results',
        'route' => 'results.index',
        'sort'  => 3,
    ], [
        'key'   => 'results.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'results.view',
        'sort'  => 2,
    ], [
        'key'   => 'results.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['results.delete', 'results.mass_delete'],
        'sort'  => 4,
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
        'key'   => 'crm',
        'name'  => 'admin::app.acl.crm',
        'route' => 'leads.index',
        'sort'  => 5,
    ], [
        'key'   => 'crm.leads',
        'name'  => 'admin::app.acl.leads',
        'route' => 'leads.index',
        'sort'  => 2,
    ], [
        'key'   => 'crm.leads.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['leads.create', 'leads.store'],
        'sort'  => 1,
    ], [
        'key'   => 'crm.leads.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'leads.view',
        'sort'  => 2,
    ], [
        'key'   => 'crm.leads.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['leads.edit', 'leads.update', 'leads.mass_update'],
        'sort'  => 3,
    ], [
        'key'   => 'crm.leads.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['leads.delete', 'leads.mass_delete'],
        'sort'  => 4,
    ], [
        'key'   => 'crm.quotes',
        'name'  => 'admin::app.acl.quotes',
        'route' => 'quotes.index',
        'sort'  => 3,
    ], [
        'key'   => 'crm.quotes.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['quotes.create', 'quotes.store'],
        'sort'  => 1,
    ], [
        'key'   => 'crm.quotes.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['quotes.edit', 'quotes.update'],
        'sort'  => 2,
    ], [
        'key'   => 'crm.quotes.print',
        'name'  => 'admin::app.acl.print',
        'route' => 'quotes.print',
        'sort'  => 3,
    ], [
        'key'   => 'crm.quotes.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['quotes.delete', 'quotes.mass_delete'],
        'sort'  => 4,
    ],  [
        'key'   => 'crm.activities',
        'name'  => 'admin::app.acl.activities',
        'route' => 'activities.index',
        'sort'  => 5,
    ], [
        'key'   => 'crm.activities.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['activities.create', 'activities.store'],
        'sort'  => 1,
    ], [
        'key'   => 'crm.activities.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['activities.edit', 'activities.update', 'activities.mass_update'],
        'sort'  => 2,
    ], [
        'key'   => 'crm.activities.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['activities.delete', 'activities.mass_delete'],
        'sort'  => 3,
    ], [
        'key'   => 'crm.products',
        'name'  => 'admin::app.acl.products',
        'route' => 'products.index',
        'sort'  => 7,
    ], [
        'key'   => 'crm.products.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['products.create', 'products.store'],
        'sort'  => 1,
    ], [
        'key'   => 'crm.products.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['products.edit', 'products.update'],
        'sort'  => 2,
    ], [
        'key'   => 'crm.products.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['products.delete', 'products.mass_delete'],
        'sort'  => 3,
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
        'key'   => 'mail',
        'name'  => 'admin::app.acl.mail',
        'route' => 'mail.index',
        'sort'  => 4,
    ], [
        'key'   => 'mail.inbox',
        'name'  => 'admin::app.acl.inbox',
        'route' => 'mail.index',
        'sort'  => 1,
    ], [
        'key'   => 'mail.draft',
        'name'  => 'admin::app.acl.draft',
        'route' => 'mail.index',
        'sort'  => 2,
    ], [
        'key'   => 'mail.outbox',
        'name'  => 'admin::app.acl.outbox',
        'route' => 'mail.index',
        'sort'  => 3,
    ], [
        'key'   => 'mail.sent',
        'name'  => 'admin::app.acl.sent',
        'route' => 'mail.index',
        'sort'  => 4,
    ], [
        'key'   => 'mail.trash',
        'name'  => 'admin::app.acl.trash',
        'route' => 'mail.index',
        'sort'  => 5,
    ], [
        'key'   => 'mail.compose',
        'name'  => 'admin::app.acl.create',
        'route' => ['mail.index', 'mail.store'],
        'sort'  => 6,
    ], [
        'key'   => 'mail.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'mail.view',
        'sort'  => 7,
    ], [
        'key'   => 'mail.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => 'mail.update',
        'sort'  => 8,
    ], [
        'key'   => 'mail.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['mail.delete', 'mail.mass_delete'],
        'sort'  => 9,
    ],   
    /*
    |--------------------------------------------------------------------------
    | CMS
    |--------------------------------------------------------------------------
    |
    | All ACLs related to cms will be placed here.
    |
    */
    [
        'key'   => 'cms',
        'name'  => 'admin::app.layouts.cms',
        'route' => 'cms.pages.index',
        'sort'  => 7,
    ], [
        'key'   => 'cms.pages',
        'name'  => 'admin::app.cms.pages.pages',
        'route' => 'cms.pages.index',
        'sort'  => 7,
    ], [
        'key'   => 'cms.pages.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'cms.pages.create',
        'sort'  => 1,
    ], [
        'key'   => 'cms.pages.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => 'cms.pages.edit',
        'sort'  => 2,
    ], [
        'key'   => 'cms.pages.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'cms.pages.delete',
        'sort'  => 3,
    ], [
        'key'   => 'cms.pages.mass-delete',
        'name'  => 'admin::app.acl.mass-delete',
        'route' => 'cms.pages.mass-delete',
        'sort'  => 4,
    ],
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | All ACLs related to settings will be placed here.
    |
    */
    [
        'key'   => 'settings',
        'name'  => 'admin::app.acl.settings',
        'route' => 'settings.index',
        'sort'  => 8,
    ], [
        'key'   => 'settings.user',
        'name'  => 'admin::app.acl.user',
        'route' => ['settings.groups.index', 'settings.roles.index', 'settings.users.index'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.user.groups',
        'name'  => 'admin::app.acl.groups',
        'route' => 'settings.groups.index',
        'sort'  => 1,
    ], [
        'key'   => 'settings.user.groups.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.groups.create', 'settings.groups.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.user.groups.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.groups.edit', 'settings.groups.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.user.groups.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.groups.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.user.roles',
        'name'  => 'admin::app.acl.roles',
        'route' => 'settings.roles.index',
        'sort'  => 2,
    ], [
        'key'   => 'settings.user.roles.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.roles.create', 'settings.roles.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.user.roles.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.roles.edit', 'settings.roles.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.user.roles.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.roles.delete',
        'sort'  => 3,
    ],  [
        'key'   => 'settings.user.users',
        'name'  => 'admin::app.acl.users',
        'route' => 'settings.users.index',
        'sort'  => 3,
    ], [
        'key'   => 'settings.user.users.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.users.create', 'settings.users.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.user.users.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.users.edit', 'settings.users.update', 'settings.users.mass_update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.user.users.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['settings.users.delete', 'settings.users.mass_delete'],
        'sort'  => 3,
    ], [
        'key'   => 'settings.lead',
        'name'  => 'admin::app.acl.lead',
        'route' => ['settings.pipelines.index', 'settings.sources.index', 'settings.types.index'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.lead.pipelines',
        'name'  => 'admin::app.acl.pipelines',
        'route' => 'settings.pipelines.index',
        'sort'  => 1,
    ], [
        'key'   => 'settings.lead.pipelines.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.pipelines.create', 'settings.pipelines.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.lead.pipelines.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.pipelines.edit', 'settings.pipelines.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.lead.pipelines.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.pipelines.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.lead.sources',
        'name'  => 'admin::app.acl.sources',
        'route' => 'settings.sources.index',
        'sort'  => 2,
    ], [
        'key'   => 'settings.lead.sources.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.sources.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.lead.sources.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.sources.edit', 'settings.sources.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.lead.sources.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.sources.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.lead.types',
        'name'  => 'admin::app.acl.types',
        'route' => 'settings.types.index',
        'sort'  => 3,
    ], [
        'key'   => 'settings.lead.types.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.types.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.lead.types.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.types.edit', 'settings.types.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.lead.types.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.types.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.automation',
        'name'  => 'admin::app.acl.automation',
        'route' => ['settings.attributes.index', 'settings.email_templates.index', 'settings.workflows.index'],
        'sort'  => 3,
    ], [
        'key'   => 'settings.automation.attributes',
        'name'  => 'admin::app.acl.attributes',
        'route' => 'settings.attributes.index',
        'sort'  => 1,
    ], [
        'key'   => 'settings.automation.attributes.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.attributes.create', 'settings.attributes.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.automation.attributes.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.attributes.edit', 'settings.attributes.update', 'settings.attributes.mass_update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.automation.attributes.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.attributes.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.automation.email_templates',
        'name'  => 'admin::app.acl.email-templates',
        'route' => 'settings.email_templates.index',
        'sort'  => 7,
    ], [
        'key'   => 'settings.automation.email_templates.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.email_templates.create', 'settings.email_templates.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.automation.email_templates.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.email_templates.edit', 'settings.email_templates.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.automation.email_templates.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.email_templates.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.automation.workflows',
        'name'  => 'admin::app.acl.workflows',
        'route' => 'settings.workflows.index',
        'sort'  => 2,
    ], [
        'key'   => 'settings.automation.workflows.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.workflows.create', 'settings.workflows.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.automation.workflows.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.workflows.edit', 'settings.workflows.update'],
        'sort'  => 2,
    ], [
        'key'   => 'settings.automation.workflows.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'settings.workflows.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.other_settings',
        'name'  => 'admin::app.acl.other-settings',
        'route' => 'settings.tags.index',
        'sort'  => 4,
    ], [
        'key'   => 'settings.other_settings.tags',
        'name'  => 'admin::app.acl.tags',
        'route' => 'settings.tags.index',
        'sort'  => 1,
    ], [
        'key'   => 'settings.other_settings.tags.create',
        'name'  => 'admin::app.acl.create',
        'route' => ['settings.tags.create', 'settings.tags.store', 'leads.tags.store', 'search.tags.store'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.other_settings.tags.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => ['settings.tags.edit', 'settings.tags.update'],
        'sort'  => 1,
    ], [
        'key'   => 'settings.other_settings.tags.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => ['settings.tags.delete', 'settings.tags.mass_delete', 'leads.tags.delete'],
        'sort'  => 2,
    ], [
        'key'   => 'configuration',
        'name'  => 'admin::app.acl.configuration',
        'route' => 'configuration.index',
        'sort'  => 9,
    ],
    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    |
    | All ACLs related to sales will be placed here.
    |
    */
    [
        'key'   => 'sales',
        'name'  => 'admin::app.acl.sales',
        'route' => 'sales.orders.index',
        'sort'  => 2,
    ], [
        'key'   => 'sales.orders',
        'name'  => 'admin::app.acl.orders',
        'route' => 'sales.orders.index',
        'sort'  => 1,
    ], [
        'key'   => 'sales.orders.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'sales.orders.view',
        'sort'  => 1,
    ], [
        'key'   => 'sales.orders.cancel',
        'name'  => 'admin::app.acl.cancel',
        'route' => 'sales.orders.cancel',
        'sort'  => 2,
    ], [
        'key'   => 'sales.invoices',
        'name'  => 'admin::app.acl.invoices',
        'route' => 'sales.invoices.index',
        'sort'  => 2,
    ], [
        'key'   => 'sales.invoices.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'sales.invoices.view',
        'sort'  => 1,
    ], [
        'key'   => 'sales.invoices.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'sales.invoices.create',
        'sort'  => 2,
    ], [
        'key'   => 'sales.refunds',
        'name'  => 'admin::app.acl.refunds',
        'route' => 'sales.refunds.index',
        'sort'  => 4,
    ], [
        'key'   => 'sales.refunds.view',
        'name'  => 'admin::app.acl.view',
        'route' => 'sales.refunds.view',
        'sort'  => 1,
    ], [
        'key'   => 'sales.refunds.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'sales.refunds.create',
        'sort'  => 2,
    ]
];
