<?php

return [
    'leads'         => [
        'name'       => 'Lead',
        'repository' => 'LeadBrowser\Lead\Repositories\LeadRepository',
    ],

    'persons'       => [
        'name'       => 'Person',
        'repository' => 'LeadBrowser\Organization\Repositories\PersonRepository',
    ],

    'organizations' => [
        'name'       => 'Organization',
        'repository' => 'LeadBrowser\Organization\Repositories\OrganizationRepository',
    ],

    'products'      => [
        'name'       => 'Product',
        'repository' => 'LeadBrowser\Product\Repositories\ProductRepository',
    ],

    'search'        => [
        'name'       => 'search',
        'repository' => 'LeadBrowser\Search\Repositories\SearchRepository',
    ],

    'quotes'      => [
        'name'       => 'Quote',
        'repository' => 'LeadBrowser\Quote\Repositories\QuoteRepository',
    ],
];