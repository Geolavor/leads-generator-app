<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(trans('admin::app.layouts.dashboard'), route('dashboard.index'));
});


// Dashboard > Leads
Breadcrumbs::for('leads', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.leads'), route('leads.index'));
});

// Dashboard > Leads > Create
Breadcrumbs::for('leads.create', function (BreadcrumbTrail $trail) {
    $trail->parent('leads');
    $trail->push(trans('admin::app.leads.create-title'), route('leads.create'));
});

// Dashboard > Leads > Title
Breadcrumbs::for('leads.view', function (BreadcrumbTrail $trail, $lead) {
    $trail->parent('leads');
    $trail->push($lead->title, route('leads.view', $lead->id));
});

// Search
Breadcrumbs::for('search', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.search'), route('search.index'));
});

// Search > Location
Breadcrumbs::for('search.location', function (BreadcrumbTrail $trail) {
    $trail->parent('search');
    $trail->push(trans('admin::app.layouts.search'), route('search.location.index'));
});

// Dashboard > Search > Create Location
Breadcrumbs::for('search.location.create', function (BreadcrumbTrail $trail) {
    $trail->parent('search');
    $trail->push(trans('admin::app.search.create-title'), route('search.location.create'));
});

// Dashboard > Search > View Location
Breadcrumbs::for('search.location.view', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('search');
    $trail->push(trans('admin::app.search.view-title'), route('search.location.view', $project->id));
});

// Search > Phones
Breadcrumbs::for('search.phones', function (BreadcrumbTrail $trail) {
    $trail->parent('search');
    $trail->push(trans('admin::app.layouts.search'), route('search.phones.index'));
});

// Dashboard > Search > Create Phones
Breadcrumbs::for('search.phones.create', function (BreadcrumbTrail $trail) {
    $trail->parent('search.phones');
    $trail->push(trans('admin::app.search.create-title'), route('search.phones.create'));
});

// Dashboard > Search > View Phones
Breadcrumbs::for('search.phones.view', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('search.phones');
    $trail->push(trans('admin::app.search.view-title'), route('search.phones.view', $project->id));
});

// Results
Breadcrumbs::for('results', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.results'), route('results.index'));
});

// Dashboard > Results > Create Result
Breadcrumbs::for('results.create', function (BreadcrumbTrail $trail) {
    $trail->parent('results');
    $trail->push(trans('admin::app.results.create-title'), route('results.create'));
});

// Dashboard > Results > Edit Result
Breadcrumbs::for('results.edit', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('results');
    $trail->push(trans('admin::app.results.edit-title'), route('results.edit', $result->id));
});

// Dashboard > Results > View Result
Breadcrumbs::for('results.view', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('results');
    $trail->push(trans('admin::app.results.view-title'), route('results.view', $result->id));
});

// Dashboard > Quotes
Breadcrumbs::for('quotes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.quotes'), route('quotes.index'));
});


// Dashboard > Quotes > Add Quote
Breadcrumbs::for('quotes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('quotes');
    $trail->push(trans('admin::app.quotes.create-title'), route('quotes.create'));
});

// Dashboard > Quotes > Edit Quote
Breadcrumbs::for('quotes.edit', function (BreadcrumbTrail $trail, $quote) {
    $trail->parent('quotes');
    $trail->push(trans('admin::app.quotes.edit-title'), route('quotes.edit', $quote->id));
});


// Mail
Breadcrumbs::for('mail', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.mail.title'), route('mail.index', ['route' => 'inbox']));
});

// Mail > [Compose | Inbox | Outbox | Draft | Sent | Trash]
Breadcrumbs::for('mail.route', function (BreadcrumbTrail $trail, $route) {
    $trail->parent('mail');
    $trail->push(trans('admin::app.mail.' . $route), route('mail.index', ['route' => $route]));
});

// Mail > [Inbox | Outbox | Draft | Sent | Trash] > Title
Breadcrumbs::for('mail.route.view', function (BreadcrumbTrail $trail, $route, $email) {
    $trail->parent('mail.route', $route);
    $trail->push($email->subject ?? '', route('mail.view', ['route' => $route, 'id' => $email->id]));
});


// Dashboard > Activities
Breadcrumbs::for('activities', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.activities'), route('activities.index'));
});

// Dashboard > activities > Edit Activity
Breadcrumbs::for('activities.edit', function (BreadcrumbTrail $trail, $activity) {
    $trail->parent('activities');
    $trail->push(trans('admin::app.activities.edit-title'), route('activities.edit', $activity->id));
});


// Dashboard > Employees
Breadcrumbs::for('employees', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.employees'), route('employees.index'));
});

// Dashboard > Employees > Create
Breadcrumbs::for('employees.create', function (BreadcrumbTrail $trail) {
    $trail->parent('employees');
    $trail->push(trans('admin::app.employees.create-title'), route('employees.create'));
});

// Dashboard > Employees > Edit
Breadcrumbs::for('employees.edit', function (BreadcrumbTrail $trail, $employee) {
    $trail->parent('employees');
    $trail->push(trans('admin::app.employees.edit-title'), route('employees.edit', $employee->id));
});


// Dashboard > Organizations
Breadcrumbs::for('organizations', function (BreadcrumbTrail $trail) {
    $trail->parent('search');
    $trail->push(trans('admin::app.layouts.organizations'), route('organizations.index'));
});

// Dashboard > Organizations > View
Breadcrumbs::for('organizations.view', function (BreadcrumbTrail $trail, $organization) {
    $trail->parent('search');
    $trail->push($organization->title, route('organizations.view', $organization->id));
});

// Dashboard > Organizations > Create
Breadcrumbs::for('organizations.create', function (BreadcrumbTrail $trail) {
    $trail->parent('search');
    $trail->push(trans('admin::app.organizations.create-title'), route('organizations.create'));
});

// Dashboard > Organizations  > Edit
Breadcrumbs::for('organizations.edit', function (BreadcrumbTrail $trail, $organization) {
    $trail->parent('search');
    $trail->push(trans('admin::app.organizations.edit-title'), route('organizations.edit', $organization->id));
});


// Products
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.products'), route('products.index'));
});

// Dashboard > Products > Create Product
Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push(trans('admin::app.products.create-title'), route('products.create'));
});

// Dashboard > Products > Edit Product
Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('products');
    $trail->push(trans('admin::app.products.edit-title'), route('products.edit', $product->id));
});


// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.settings'), route('settings.index'));
});

// Settings > Groups
Breadcrumbs::for('settings.groups', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.groups'), route('settings.groups.index'));
});

// Dashboard > Groups > Create Group
Breadcrumbs::for('settings.groups.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.groups');
    $trail->push(trans('admin::app.settings.groups.create-title'), route('settings.groups.create'));
});

// Dashboard > Groups > Edit Group
Breadcrumbs::for('settings.groups.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('settings.groups');
    $trail->push(trans('admin::app.settings.groups.edit-title'), route('settings.groups.edit', $role->id));
});


// Settings > Roles
Breadcrumbs::for('settings.roles', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.roles'), route('settings.roles.index'));
});

// Dashboard > Roles > Create Role
Breadcrumbs::for('settings.roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.roles');
    $trail->push(trans('admin::app.settings.roles.create-title'), route('settings.roles.create'));
});

// Dashboard > Roles > Edit Role
Breadcrumbs::for('settings.roles.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('settings.roles');
    $trail->push(trans('admin::app.settings.roles.edit-title'), route('settings.roles.edit', $role->id));
});


// Settings > Users
Breadcrumbs::for('settings.users', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.users'), route('settings.users.index'));
});

// Dashboard > Users > Create Role
Breadcrumbs::for('settings.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.users');
    $trail->push(trans('admin::app.settings.users.create-title'), route('settings.users.create'));
});

// Dashboard > Users > Edit Role
Breadcrumbs::for('settings.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('settings.users');
    $trail->push(trans('admin::app.settings.users.edit-title'), route('settings.users.edit', $user->id));
});


// Settings > Attributes
Breadcrumbs::for('settings.attributes', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.attributes'), route('settings.attributes.index'));
});

// Dashboard > Attributes > Create Attribute
Breadcrumbs::for('settings.attributes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.attributes');
    $trail->push(trans('admin::app.settings.attributes.create-title'), route('settings.attributes.create'));
});

// Dashboard > Attributes > Edit Attribute
Breadcrumbs::for('settings.attributes.edit', function (BreadcrumbTrail $trail, $attribute) {
    $trail->parent('settings.attributes');
    $trail->push(trans('admin::app.settings.attributes.edit-title'), route('settings.attributes.edit', $attribute->id));
});


// Settings > Pipelines
Breadcrumbs::for('settings.pipelines', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.pipelines'), route('settings.pipelines.index'));
});

// Dashboard > Pipelines > Create Pipeline
Breadcrumbs::for('settings.pipelines.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.pipelines');
    $trail->push(trans('admin::app.settings.pipelines.create-title'), route('settings.pipelines.create'));
});

// Dashboard > Pipelines > Edit Pipeline
Breadcrumbs::for('settings.pipelines.edit', function (BreadcrumbTrail $trail, $pipeline) {
    $trail->parent('settings.pipelines');
    $trail->push(trans('admin::app.settings.pipelines.edit-title'), route('settings.pipelines.edit', $pipeline->id));
});


// Settings > Sources
Breadcrumbs::for('settings.sources', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.sources'), route('settings.sources.index'));
});

// Dashboard > Sources > Edit Source
Breadcrumbs::for('settings.sources.edit', function (BreadcrumbTrail $trail, $source) {
    $trail->parent('settings.sources');
    $trail->push(trans('admin::app.settings.sources.edit-title'), route('settings.sources.edit', $source->id));
});


// Settings > Types
Breadcrumbs::for('settings.types', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.types'), route('settings.types.index'));
});

// Dashboard > Types > Edit Type
Breadcrumbs::for('settings.types.edit', function (BreadcrumbTrail $trail, $type) {
    $trail->parent('settings.types');
    $trail->push(trans('admin::app.settings.types.edit-title'), route('settings.types.edit', $type->id));
});


// Settings > Email Templates
Breadcrumbs::for('settings.mailbox_templates', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.email-templates'), route('settings.mailbox_templates.index'));
});

// Dashboard > Email Templates > Create Email Template
Breadcrumbs::for('settings.mailbox_templates.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.mailbox_templates');
    $trail->push(trans('admin::app.settings.email-templates.create-title'), route('settings.mailbox_templates.create'));
});

// Dashboard > Email Templates > Edit Email Template
Breadcrumbs::for('settings.mailbox_templates.edit', function (BreadcrumbTrail $trail, $emailTemplate) {
    $trail->parent('settings.mailbox_templates');
    $trail->push(trans('admin::app.settings.email-templates.edit-title'), route('settings.mailbox_templates.edit', $emailTemplate->id));
});


// Settings > Workflows
Breadcrumbs::for('settings.workflows', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.workflows'), route('settings.workflows.index'));
});

// Dashboard > Workflows > Create Workflow
Breadcrumbs::for('settings.workflows.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.workflows');
    $trail->push(trans('admin::app.settings.workflows.create-title'), route('settings.workflows.create'));
});

// Dashboard > Workflows > Edit Workflow
Breadcrumbs::for('settings.workflows.edit', function (BreadcrumbTrail $trail, $workflow) {
    $trail->parent('settings.workflows');
    $trail->push(trans('admin::app.settings.workflows.edit-title'), route('settings.workflows.edit', $workflow->id));
});


// Settings > Tags
Breadcrumbs::for('settings.tags', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.tags'), route('settings.tags.index'));
});

// Dashboard > Tags > Edit Tag
Breadcrumbs::for('settings.tags.edit', function (BreadcrumbTrail $trail, $tag) {
    $trail->parent('settings.tags');
    $trail->push(trans('admin::app.settings.tags.edit-title'), route('settings.tags.edit', $tag->id));
});


// Settings > Population
Breadcrumbs::for('settings.populations', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push(trans('admin::app.layouts.populations'), route('settings.populations.index'));
});

// Dashboard > Populations > Edit Population
Breadcrumbs::for('settings.populations.edit', function (BreadcrumbTrail $trail, $source) {
    $trail->parent('settings.populations');
    $trail->push(trans('admin::app.settings.populations.edit-title'), route('settings.populations.edit', $source->id));
});


// Configuration
Breadcrumbs::for('configuration', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('admin::app.layouts.configuration'), route('configuration.index'));
});

// Configuration > Config
Breadcrumbs::for('configuration.slug', function (BreadcrumbTrail $trail, $slug) {
    $trail->parent('configuration');
    $trail->push('', route('configuration.index', ['slug' => $slug]));
});