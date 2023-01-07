<?php

use LeadBrowser\User\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'stripe' => [
        'model'  => User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /**
     * Integrations
     */
    'zoho' => [    
        'client_id' => env('ZOHO_CLIENT_ID'),  
        'client_secret' => env('ZOHO_CLIENT_SECRET'),  
        'redirect' => env('ZOHO_REDIRECT_URI') 
    ],
    'pipedrive' => [    
        'client_id' => env('PIPEDRIVE_CLIENT_ID'),  
        'client_secret' => env('PIPEDRIVE_CLIENT_SECRET'),  
        'redirect' => env('PIPEDRIVE_REDIRECT_URI') 
    ],
    'pipedrive' => [    
        'client_id' => env('PIPEDRIVE_CLIENT_ID'),  
        'client_secret' => env('PIPEDRIVE_CLIENT_SECRET'),  
        'redirect' => env('PIPEDRIVE_REDIRECT_URI') 
    ],
    'intercom' => [    
        'client_id' => env('INTERCOM_CLIENT_ID'),  
        'client_secret' => env('INTERCOM_CLIENT_SECRET'),  
        'redirect' => env('INTERCOM_REDIRECT_URI') 
    ],
    'salesforce' => [    
        'client_id' => env('SALESFORCE_CLIENT_ID'),  
        'client_secret' => env('SALESFORCE_CLIENT_SECRET'),  
        'redirect' => env('SALESFORCE_REDIRECT_URI') 
    ],
];
