<?php

use LeadBrowser\Admin\Http\Controllers\CMS\BlogController;
use LeadBrowser\Admin\Http\Controllers\CMS\PageController;
use LeadBrowser\Admin\Http\Controllers\Payments\SubscriptionController;
use LeadBrowser\Notification\Http\Controllers\Admin\NotificationController;
use LeadBrowser\Marketing\Http\Controllers\EventController;
use LeadBrowser\Marketing\Http\Controllers\TemplateController;
use LeadBrowser\Admin\Http\Controllers\Sales\InvoiceController;
use LeadBrowser\Admin\Http\Controllers\Sales\OrderController;
use LeadBrowser\Admin\Http\Controllers\Sales\RefundController;
use LeadBrowser\Admin\Http\Controllers\Sales\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {

    // Route::get('/', 'LeadBrowser\Admin\Http\Controllers\Controller@redirectToLogin')->name('landing.home');

    Route::get('/', 'LeadBrowser\Admin\Http\Controllers\Landing\LandingController@index')->name('landing.home');

    // Solutions Routes
    Route::get('solutions', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@solutions')->name('solutions.home');

    // Terms Routes
    Route::get('terms', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@terms')->name('terms.home');
    Route::get('privacy', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@privacy')->name('privacy.home');
    Route::get('robot', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@robot')->name('robot.home');
    Route::get('cookie', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@robot')->name('cookie.home');
    
    Route::get('pricing', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@pricing')->name('pricing.home');
    Route::get('compare', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@compare')->name('compare.home');
    
    Route::get('contact', 'LeadBrowser\Admin\Http\Controllers\System\ContactFormController@create')->name('contact.create');
    Route::post('contact', 'LeadBrowser\Admin\Http\Controllers\System\ContactFormController@store')->name('contact.store');
    
    // IOD Routes
    Route::get('claim', 'LeadBrowser\Admin\Http\Controllers\System\ClaimController@create')->name('claim.create');

    // IOD Routes
    Route::post('claim', 'LeadBrowser\Admin\Http\Controllers\System\ClaimController@store')->name('claim.store');

    // IOD  Routes
    Route::get('claim/{token}', 'LeadBrowser\Admin\Http\Controllers\System\ClaimController@verify')->name('claim.verify');

    // Payment Routes
    Route::get('payments', 'LeadBrowser\Admin\Http\Controllers\Payments\PaymentsController@create')->name('payments.create');

    // Payment Routes
    Route::post('payments', 'LeadBrowser\Admin\Http\Controllers\Payments\PaymentsController@store')->name('payments.store')->middleware(['user']);

    // Payment Routes
    Route::get('payment/callback', 'LeadBrowser\Admin\Http\Controllers\Payments\PaymentsController@callback')->name('payments.callback');

    /* Name: subscriptions
    * Url: /subscriptions/*
    * Route: subscriptions.*
    */
    Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
        Route::get('/resume/{subscription}', [SubscriptionController::class, 'update'])->name('update');
        Route::get('/cancel/{subscription}', [SubscriptionController::class, 'destroy'])->name('destroy');
    });

    /**
     * CMS pages and blogs.
     */
    Route::get('page/{slug}', [PageController::class, 'view'])->name('cms.page');
    Route::get('blogs', [BlogController::class, 'list'])->name('cms.blogs');
    Route::get('blog/{slug}', [BlogController::class, 'view'])->name('cms.blog');

    // Login Routes
    Route::get('login', 'LeadBrowser\Admin\Http\Controllers\User\SessionController@create')->name('auth.login.create');

    // Login post route to admin auth controller
    Route::post('login', 'LeadBrowser\Admin\Http\Controllers\User\SessionController@store')->name('auth.login.store');

    // Register Routes
    Route::get('register', 'LeadBrowser\Admin\Http\Controllers\User\RegisterController@create')->name('auth.register.create');

    // Register post route to admin auth controller
    Route::post('register', 'LeadBrowser\Admin\Http\Controllers\User\RegisterController@store')->name('auth.register.store');

    // Auth::routes(['verify' => true]);

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect('/browser');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('/plans', 'LeadBrowser\Admin\Http\Controllers\Payments\PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'LeadBrowser\Admin\Http\Controllers\Payments\PlanController@show')->name('plans.view');
    
    Route::post('/subscription', 'LeadBrowser\Admin\Http\Controllers\Payments\SubscriptionController@create')->name('subscription.create');

    /**
     * Test controller
     */
    Route::get('test', 'LeadBrowser\Admin\Http\Controllers\System\SystemController@index')->name('system.test');

    // Forget Password Routes
    Route::get('forgot-password', 'LeadBrowser\Admin\Http\Controllers\User\ForgotPasswordController@create')->name('forgot_password.create');

    Route::post('forgot-password', 'LeadBrowser\Admin\Http\Controllers\User\ForgotPasswordController@store')->name('forgot_password.store');

    // Reset Password Routes
    Route::get('reset-password/{token}', 'LeadBrowser\Admin\Http\Controllers\User\ResetPasswordController@create')->name('reset_password.create');

    Route::post('reset-password', 'LeadBrowser\Admin\Http\Controllers\User\ResetPasswordController@store')->name('reset_password.store');

    Route::get('mail/inbound-parse', 'LeadBrowser\Admin\Http\Controllers\Mail\EmailController@inboundParse')->name('mail.inbound_parse');

    // Admin Routes
    Route::group(['middleware' => ['user']], function () {

        // Notifications
        // Route::get('notifications', [NotificationController::class, 'index'])->defaults('_config', [
        //     'view' => 'admin::notifications.index',
        // ])->name('notification.index');
    
        // Route::get('get-notifications', [NotificationController::class, 'getNotifications'])
        //     ->name('notification.get-notification');
    
        // Route::get('viewed-notifications/{orderId}', [NotificationController::class, 'viewedNotifications'])
        //     ->name('notification.viewed-notification');
    
        // Route::post('read-all-notifications', [NotificationController::class, 'readAllNotifications'])
        //     ->name('notification.read-all');

        Route::get('logout', 'LeadBrowser\Admin\Http\Controllers\User\SessionController@destroy')->name('session.destroy');

        // Dashboard Route
        Route::get('dashboard', 'LeadBrowser\Admin\Http\Controllers\Admin\DashboardController@index')->name('dashboard.index');

        // Marketplace Route
        Route::get('marketplace', 'LeadBrowser\Admin\Http\Controllers\Marketplace\MarketplaceController@index')->name('marketplace.index');

        Route::get('template', 'LeadBrowser\Admin\Http\Controllers\Admin\DashboardController@template')->name('dashboard.template');

        // API routes
        Route::group([
            'prefix'    => 'api',
        ], function () {
            Route::group([
                'prefix'    => 'dashboard',
            ], function () {
                Route::get('/', 'LeadBrowser\Admin\Http\Controllers\Admin\DashboardController@getCardData')->name('api.dashboard.card.index');

                Route::get('/cards', 'LeadBrowser\Admin\Http\Controllers\Admin\DashboardController@getCards')->name('api.dashboard.cards.index');

                Route::post('/cards', 'LeadBrowser\Admin\Http\Controllers\Admin\DashboardController@updateCards')->name('api.dashboard.cards.update');
            });
        });

        // User Routes
        Route::group([
            'prefix'    => 'account',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\User'
        ], function () {
            Route::get('', 'AccountController@edit')->name('user.account.edit');

            Route::put('update', 'AccountController@update')->name('user.account.update');

            Route::get('billing', 'BillingController@index')->name('user.account.billing.index');
            Route::get('billing/{invoice}', 'BillingController@download')->name('user.account.billing.download');

            Route::get('current-plan', 'SubscriptionController@index')->name('user.account.current-plan.index');

            Route::get('api', 'ApiController@index')->name('user.account.api.index');

            Route::get('integrations', 'IntegrationController@index')->name('user.account.integrations.index');
            Route::post('integrations/{integration}', 'IntegrationController@toggle')->name('user.account.integrations.toggle');

            Route::post('delete', 'AccountController@delete')->name('user.account.delete');

            Route::post('delete-card', 'AccountController@deleteCreditCard')->name('user.account.delete-card');
        });

        // Leads Routes
        Route::group([
            'prefix'    => 'leads',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Lead',
        ], function () {
            Route::get('create', 'LeadController@create')->name('leads.create');

            Route::post('create', 'LeadController@store')->name('leads.store');

            Route::get('view/{id?}', 'LeadController@view')->name('leads.view');

            Route::put('edit/{id?}', 'LeadController@update')->name('leads.update');

            Route::get('search', 'LeadController@search')->name('leads.search');

            Route::delete('{id}', 'LeadController@destroy')->name('leads.delete');

            Route::put('mass-update', 'LeadController@massUpdate')->name('leads.mass_update');

            Route::put('mass-destroy', 'LeadController@massDestroy')->name('leads.mass_delete');

            Route::post('tags/{id}', 'TagController@store')->name('leads.tags.store');

            Route::delete('{lead_id}/{tag_id?}', 'TagController@delete')->name('leads.tags.delete');

            Route::get('get/{pipeline_id?}', 'LeadController@get')->name('leads.get');

            Route::get('{pipeline_id?}', 'LeadController@index')->name('leads.index');

            Route::group([
                'prefix'    => 'quotes',
            ], function () {
                Route::delete('{lead_id}/{quote_id?}', 'QuoteController@delete')->name('leads.quotes.delete');
            });
        });

        // Results Routes
        Route::group([
            'prefix'    => 'results',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Result'
        ], function () {  

            Route::get('', 'ResultController@index')->name('results.index');

            Route::get('create', 'ResultController@create')->name('results.create');

            Route::post('create', 'ResultController@store')->name('results.store');

            Route::get('view/{id?}', 'ResultController@view')->name('results.view');

            Route::get('edit/{id}', 'ResultController@edit')->name('results.edit');

            Route::put('edit/{id}', 'ResultController@update')->name('results.update');

            Route::get('search', 'ResultController@search')->name('results.search');

            Route::delete('{id}', 'ResultController@destroy')->name('results.delete');

            Route::put('mass-destroy', 'ResultController@massDestroy')->name('results.mass_delete');

            Route::put('mass-add-to-prospects', 'ResultController@massAddToContact')->name('results.mass_add_to_contact');

            Route::post('transfer', 'ResultController@transfer')->name('results.transfer');

            Route::post('export', 'ResultController@export')->name('results.export');
        });
        
        // Searchs Routes
        Route::group([
            'prefix'    => 'search',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Search'
        ], function () {  

            Route::get('', 'SearchController@index')->name('search.index');

            // Groups Routes
            Route::prefix('location')->group(function () {

                Route::get('', 'LocationController@index')->name('search.location.index');

                Route::get('create', 'LocationController@create')->name('search.location.create');

                Route::post('create', 'LocationController@store')->name('search.location.store');

                Route::post('more', 'LocationController@more')->name('search.location.more');

                Route::get('view/{id?}', 'LocationController@view')->name('search.location.view');

                Route::get('search', 'LocationController@search')->name('search.location.search');

                Route::post('tags/{id}', 'TagController@store')->name('search.tags.store');

                Route::delete('{search_id}/{tag_id?}', 'TagController@delete')->name('search.tags.delete');

                Route::delete('{id}', 'LocationController@destroy')->name('search.location.delete');

                Route::put('mass-destroy', 'LocationController@massDestroy')->name('search.location.mass_delete');
                
            });

            // Groups Routes
            Route::prefix('websites')->group(function () {

                Route::get('', 'WebsiteController@index')->name('search.websites.index');

                Route::get('create', 'WebsiteController@create')->name('search.websites.create');

                Route::post('create', 'WebsiteController@store')->name('search.websites.store');

                Route::post('save', 'WebsiteController@processImport')->name('search.websites.save');

                Route::post('more', 'WebsiteController@more')->name('search.websites.more');

                Route::get('view/{id?}', 'WebsiteController@view')->name('search.websites.view');

                Route::get('search', 'WebsiteController@search')->name('search.websites.search');

                Route::delete('{id}', 'WebsiteController@destroy')->name('search.websites.delete');

                Route::put('mass-destroy', 'WebsiteController@massDestroy')->name('search.websites.mass_delete');
                
            });

            // Groups Routes
            Route::prefix('phones')->group(function () {

                Route::get('', 'PhoneController@index')->name('search.phones.index');

                Route::get('create', 'PhoneController@create')->name('search.phones.create');

                Route::post('create', 'PhoneController@store')->name('search.phones.store');

                Route::post('save', 'PhoneController@processImport')->name('search.phones.save');

                Route::get('view/{id?}', 'PhoneController@view')->name('search.phones.view');

                Route::get('search', 'PhoneController@search')->name('search.phones.search');

                Route::delete('{id}', 'PhoneController@destroy')->name('search.phones.delete');

                Route::put('mass-destroy', 'PhoneController@massDestroy')->name('search.phones.mass_delete');

            });

        });

        // Leads Routes
        Route::group([
            'prefix'    => 'quotes',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Quote',
        ], function () {
            Route::get('', 'QuoteController@index')->name('quotes.index');

            Route::get('create/{id?}', 'QuoteController@create')->name('quotes.create');

            Route::post('create', 'QuoteController@store')->name('quotes.store');

            Route::get('edit/{id?}', 'QuoteController@edit')->name('quotes.edit');

            Route::put('edit/{id}', 'QuoteController@update')->name('quotes.update');

            Route::get('print/{id?}', 'QuoteController@print')->name('quotes.print');

            Route::delete('{id}', 'QuoteController@destroy')->name('quotes.delete');

            Route::put('mass-destroy', 'QuoteController@massDestroy')->name('quotes.mass_delete');
        });

        Route::group([
            'prefix'    => 'activities',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Activity',
        ], function () {
            Route::get('', 'ActivityController@index')->name('activities.index');

            Route::get('get', 'ActivityController@get')->name('activities.get');

            Route::post('is-overlapping', 'ActivityController@checkIfOverlapping')->name('activities.check_overlapping');

            Route::post('create', 'ActivityController@store')->name('activities.store');

            Route::get('edit/{id?}', 'ActivityController@edit')->name('activities.edit');

            Route::put('edit/{id?}', 'ActivityController@update')->name('activities.update');

            Route::get('search-participants', 'ActivityController@searchParticipants')->name('activities.search_participants');

            Route::post('file-upload', 'ActivityController@upload')->name('activities.file_upload');

            Route::get('file-download/{id?}', 'ActivityController@download')->name('activities.file_download');

            Route::delete('{id?}', 'ActivityController@destroy')->name('activities.delete');

            Route::put('mass-update', 'ActivityController@massUpdate')->name('activities.mass_update');

            Route::put('mass-destroy', 'ActivityController@massDestroy')->name('activities.mass_delete');
        });

        Route::group([
            'prefix'    => 'mail',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Mailbox',
        ], function () {
            Route::post('create', 'MailboxController@store')->name('mail.store');

            Route::put('edit/{id?}', 'MailboxController@update')->name('mail.update');

            Route::get('attachment-download/{id?}', 'MailboxController@download')->name('mail.attachment_download');

            Route::get('{route?}', 'MailboxController@index')->name('mail.index');

            Route::get('{route?}/{id?}', 'MailboxController@view')->name('mail.view');

            Route::delete('{id?}', 'MailboxController@destroy')->name('mail.delete');

            Route::put('mass-update', 'MailboxController@massUpdate')->name('mail.mass_update');

            Route::put('mass-destroy', 'MailboxController@massDestroy')->name('mail.mass_delete');
        });

        // Contacts Routes
        Route::group([
            'prefix'    => 'employees',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Employee'
        ], function () {
            Route::get('', 'EmployeeController@index')->name('employees.index');

            Route::get('create', 'EmployeeController@create')->name('employees.create');

            Route::post('create', 'EmployeeController@store')->name('employees.store');

            Route::get('view/{id?}', 'EmployeeController@view')->name('employees.view');

            Route::get('edit/{id?}', 'EmployeeController@edit')->name('employees.edit');

            Route::put('edit/{id}', 'EmployeeController@update')->name('employees.update');

            Route::get('search', 'EmployeeController@search')->name('employees.search');

            Route::delete('{id}', 'EmployeeController@destroy')->name('employees.delete');

            Route::put('mass-destroy', 'EmployeeController@massDestroy')->name('employees.mass_delete');

            Route::post('score', 'EmployeeController@score')->name('employees.score');
        });

        Route::group([
            'prefix'    => 'organizations',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Organization'
        ], function () {
            Route::get('', 'OrganizationController@index')->name('organizations.index');

            Route::get('create', 'OrganizationController@create')->name('organizations.create');

            Route::post('create', 'OrganizationController@store')->name('organizations.store');

            Route::get('view/{id?}', 'OrganizationController@view')->name('organizations.view');

            Route::get('edit/{id?}', 'OrganizationController@edit')->name('organizations.edit');

            Route::put('edit/{id}', 'OrganizationController@update')->name('organizations.update');

            Route::delete('{id}', 'OrganizationController@destroy')->name('organizations.delete');

            Route::put('mass-destroy', 'OrganizationController@massDestroy')->name('organizations.mass_delete');

            Route::post('buy', 'OrganizationController@buy')->name('organizations.buy');

            Route::put('mass-buy', 'OrganizationController@massBuy')->name('organizations.mass_buy');

            Route::post('tags/{id}', 'TagController@store')->name('organizations.tags.store');

            Route::delete('{prospect_id}/{tag_id?}', 'TagController@delete')->name('organizations.tags.delete');

            Route::post('transfer', 'OrganizationController@transfer')->name('organizations.transfer');
        });

        // Products Routes
        Route::group([
            'prefix'    => 'products',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Product'
        ], function () {
            Route::get('', 'ProductController@index')->name('products.index');

            Route::get('create', 'ProductController@create')->name('products.create');

            Route::post('create', 'ProductController@store')->name('products.store');

            Route::get('edit/{id}', 'ProductController@edit')->name('products.edit');

            Route::put('edit/{id}', 'ProductController@update')->name('products.update');

            Route::get('search', 'ProductController@search')->name('products.search');

            Route::delete('{id}', 'ProductController@destroy')->name('products.delete');

            Route::put('mass-destroy', 'ProductController@massDestroy')->name('products.mass_delete');
        });

        // Payments Routes
        Route::group([
            'prefix'    => 'payments',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Product'
        ], function () {
            Route::get('', 'ProductController@index')->name('payments.index');

            Route::get('create', 'ProductController@create')->name('payments.create');

            Route::post('create', 'ProductController@store')->name('payments.store2');

            Route::get('edit/{id}', 'ProductController@edit')->name('payments.edit');

            Route::put('edit/{id}', 'ProductController@update')->name('payments.update');

            Route::get('search', 'ProductController@search')->name('payments.search');

            Route::delete('{id}', 'ProductController@destroy')->name('payments.delete');

            Route::put('mass-destroy', 'ProductController@massDestroy')->name('payments.mass_delete');
        });

        Route::group([
            'prefix'    => 'cms',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\CMS'
        ], function () {

            Route::prefix('pages')->group(function () {

                Route::get('/', 'PageController@index')->name('cms.pages.index');
        
                Route::get('create', 'PageController@create')->defaults('_config', [
                    'view' => 'admin::cms.create',
                ])->name('cms.pages.create');
        
                Route::post('create', 'PageController@store')->defaults('_config', [
                    'redirect' => 'cms.pages.index',
                ])->name('cms.pages.store');
        
                Route::get('edit/{id}', 'PageController@edit')->defaults('_config', [
                    'view' => 'admin::cms.pages.edit',
                ])->name('cms.pages.edit');
        
                Route::post('edit/{id}', 'PageController@update')->defaults('_config', [
                    'redirect' => 'cms.pages.index',
                ])->name('cms.pages.update');
        
                Route::post('/delete/{id}', 'PageController@delete')->defaults('_config', [
                    'redirect' => 'cms.pages.index',
                ])->name('cms.pages.delete');
        
                Route::post('/massdelete', 'PageController@massDelete')->defaults('_config', [
                    'redirect' => 'cms.pages.index',
                ])->name('cms.pages.mass-delete');

            });

            Route::prefix('blogs')->group(function () {

                Route::get('/', 'BlogController@index')->name('cms.blogs.index');
        
                Route::get('create', 'BlogController@create')->defaults('_config', [
                    'view' => 'admin::cms.blogs.create',
                ])->name('cms.blogs.create');
        
                Route::post('create', 'BlogController@store')->defaults('_config', [
                    'redirect' => 'cms.blogs.index',
                ])->name('cms.blogs.store');
        
                Route::get('edit/{id}', 'BlogController@edit')->defaults('_config', [
                    'view' => 'admin::cms.blogs.edit',
                ])->name('cms.blogs.edit');
        
                Route::post('edit/{id}', 'BlogController@update')->defaults('_config', [
                    'redirect' => 'cms.blogs.index',
                ])->name('cms.blogs.update');
        
                Route::post('/delete/{id}', 'BlogController@delete')->defaults('_config', [
                    'redirect' => 'cms.blogs.index',
                ])->name('cms.blogs.delete');
        
                Route::post('/massdelete', 'BlogController@massDelete')->defaults('_config', [
                    'redirect' => 'cms.blogs.index',
                ])->name('cms.blogs.mass-delete');

            });

        });

        // Settings Routes
        Route::group([
            'prefix'    => 'settings',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Setting'
        ], function () {

            Route::get('', 'SettingController@index')->name('settings.index');

            // Search Types Routes
            Route::prefix('search-types')->group(function () {
                Route::get('', 'SearchTypeController@index')->name('settings.search.types.index');

                Route::post('create', 'SearchTypeController@store')->name('settings.search.types.store');

                Route::get('edit/{id?}', 'SearchTypeController@edit')->name('settings.search.types.edit');

                Route::put('edit/{id}', 'SearchTypeController@update')->name('settings.search.types.update');

                Route::delete('{id}', 'SearchTypeController@destroy')->name('settings.search.types.delete');
            });

            // Groups Routes
            Route::prefix('groups')->group(function () {
                Route::get('', 'GroupController@index')->name('settings.groups.index');

                Route::get('create', 'GroupController@create')->name('settings.groups.create');

                Route::post('create', 'GroupController@store')->name('settings.groups.store');

                Route::get('edit/{id}', 'GroupController@edit')->name('settings.groups.edit');

                Route::put('edit/{id}', 'GroupController@update')->name('settings.groups.update');

                Route::delete('{id}', 'GroupController@destroy')->name('settings.groups.delete');
            });

            // Roles Routes
            Route::prefix('roles')->group(function () {
                Route::get('', 'RoleController@index')->name('settings.roles.index');

                Route::get('create', 'RoleController@create')->name('settings.roles.create');

                Route::post('create', 'RoleController@store')->name('settings.roles.store');

                Route::get('edit/{id}', 'RoleController@edit')->name('settings.roles.edit');

                Route::put('edit/{id}', 'RoleController@update')->name('settings.roles.update');

                Route::delete('{id}', 'RoleController@destroy')->name('settings.roles.delete');
            });

            // Users Routes
            Route::prefix('users')->group(function () {
                Route::get('', 'UserController@index')->name('settings.users.index');

                Route::get('create', 'UserController@create')->name('settings.users.create');

                Route::post('create', 'UserController@store')->name('settings.users.store');

                Route::get('edit/{id?}', 'UserController@edit')->name('settings.users.edit');

                Route::put('edit/{id}', 'UserController@update')->name('settings.users.update');

                Route::delete('{id}', 'UserController@destroy')->name('settings.users.delete');

                Route::put('mass-update', 'UserController@massUpdate')->name('settings.users.mass_update');

                Route::put('mass-destroy', 'UserController@massDestroy')->name('settings.users.mass_delete');
            });

            // Attributes Routes
            Route::prefix('attributes')->group(function () {
                Route::get('', 'AttributeController@index')->name('settings.attributes.index');

                Route::get('create', 'AttributeController@create')->name('settings.attributes.create');

                Route::post('create', 'AttributeController@store')->name('settings.attributes.store');

                Route::get('edit/{id}', 'AttributeController@edit')->name('settings.attributes.edit');

                Route::put('edit/{id}', 'AttributeController@update')->name('settings.attributes.update');

                Route::get('lookup/{lookup?}', 'AttributeController@lookup')->name('settings.attributes.lookup');

                Route::delete('{id}', 'AttributeController@destroy')->name('settings.attributes.delete');

                Route::put('mass-update', 'AttributeController@massUpdate')->name('settings.attributes.mass_update');

                Route::put('mass-destroy', 'AttributeController@massDestroy')->name('settings.attributes.mass_delete');

                Route::get('download', 'AttributeController@download')->name('settings.attributes.download');
            });


            // Lead Pipelines Routes
            Route::prefix('pipelines')->group(function () {
                Route::get('', 'PipelineController@index')->name('settings.pipelines.index');

                Route::get('create', 'PipelineController@create')->name('settings.pipelines.create');

                Route::post('create', 'PipelineController@store')->name('settings.pipelines.store');

                Route::get('edit/{id?}', 'PipelineController@edit')->name('settings.pipelines.edit');

                Route::put('edit/{id}', 'PipelineController@update')->name('settings.pipelines.update');

                Route::delete('{id}', 'PipelineController@destroy')->name('settings.pipelines.delete');
            });


            // Lead Sources Routes
            Route::prefix('sources')->group(function () {
                Route::get('', 'SourceController@index')->name('settings.sources.index');

                Route::post('create', 'SourceController@store')->name('settings.sources.store');

                Route::get('edit/{id?}', 'SourceController@edit')->name('settings.sources.edit');

                Route::put('edit/{id}', 'SourceController@update')->name('settings.sources.update');

                Route::delete('{id}', 'SourceController@destroy')->name('settings.sources.delete');
            });


            // Lead Types Routes
            Route::prefix('types')->group(function () {
                Route::get('', 'TypeController@index')->name('settings.types.index');

                Route::post('create', 'TypeController@store')->name('settings.types.store');

                Route::get('edit/{id?}', 'TypeController@edit')->name('settings.types.edit');

                Route::put('edit/{id}', 'TypeController@update')->name('settings.types.update');

                Route::delete('{id}', 'TypeController@destroy')->name('settings.types.delete');
            });


            // Email Templates Routes
            Route::prefix('email-templates')->group(function () {
                Route::get('', 'EmailTemplateController@index')->name('settings.email_templates.index');

                Route::get('create', 'EmailTemplateController@create')->name('settings.email_templates.create');

                Route::post('create', 'EmailTemplateController@store')->name('settings.email_templates.store');

                Route::get('edit/{id?}', 'EmailTemplateController@edit')->name('settings.email_templates.edit');

                Route::put('edit/{id}', 'EmailTemplateController@update')->name('settings.email_templates.update');

                Route::delete('{id}', 'EmailTemplateController@destroy')->name('settings.email_templates.delete');
            });


            // Workflows Routes
            Route::prefix('workflows')->group(function () {
                Route::get('', 'WorkflowController@index')->name('settings.workflows.index');

                Route::get('create', 'WorkflowController@create')->name('settings.workflows.create');

                Route::post('create', 'WorkflowController@store')->name('settings.workflows.store');

                Route::get('edit/{id?}', 'WorkflowController@edit')->name('settings.workflows.edit');

                Route::put('edit/{id}', 'WorkflowController@update')->name('settings.workflows.update');

                Route::delete('{id}', 'WorkflowController@destroy')->name('settings.workflows.delete');
            });


            // Tags Routes
            Route::prefix('tags')->group(function () {
                Route::get('', 'TagController@index')->name('settings.tags.index');

                Route::post('create', 'TagController@store')->name('settings.tags.store');

                Route::get('edit/{id?}', 'TagController@edit')->name('settings.tags.edit');

                Route::put('edit/{id}', 'TagController@update')->name('settings.tags.update');

                Route::get('search', 'TagController@search')->name('settings.tags.search');

                Route::delete('{id}', 'TagController@destroy')->name('settings.tags.delete');

                Route::put('mass-destroy', 'TagController@massDestroy')->name('settings.tags.mass_delete');
            });

            // Population Sources Routes
            Route::prefix('populations')->group(function () {
                Route::get('', 'PopulationController@index')->name('settings.populations.index');

                Route::post('create', 'PopulationController@store')->name('settings.populations.store');

                Route::get('edit/{id?}', 'PopulationController@edit')->name('settings.populations.edit');

                Route::put('edit/{id}', 'PopulationController@update')->name('settings.populations.update');

                Route::delete('{id}', 'PopulationController@destroy')->name('settings.populations.delete');
            });

            // BlackList Sources Routes
            Route::prefix('reports')->group(function () {
                Route::get('', 'BlackListController@index')->name('settings.reports.index');

                Route::delete('{id}', 'BlackListController@destroy')->name('settings.reports.delete');
            });

            // Plans Sources Routes
            Route::prefix('plans')->group(function () {

                Route::get('', 'PlanController@index')->name('settings.plans.index');

                Route::get('create', 'PlanController@create')->name('settings.plan.create');

                Route::post('store', 'PlanController@store')->name('settings.plan.store');

                Route::get('edit/{id?}', 'PlanController@edit')->name('settings.plan.edit');

                Route::put('edit/{id}', 'PlanController@update')->name('settings.plan.update');

                Route::delete('{id}', 'PlanController@destroy')->name('settings.plan.delete');
            
            });

        });

        // Configuration Routes
        Route::group([
            'prefix'    => 'configuration',
            'namespace' => 'LeadBrowser\Admin\Http\Controllers\Configuration'
        ], function () {
            Route::get('{slug?}', 'ConfigurationController@index')->name('configuration.index');

            Route::post('{slug?}', 'ConfigurationController@store')->name('configuration.index.store');
        });

        Route::prefix('promotions')->group(function () {
            /**
             * Emails templates routes.
             */
            Route::get('email-templates', [TemplateController::class, 'index'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.templates.index',
            ])->name('email-templates.index');
    
            Route::get('email-templates/create', [TemplateController::class, 'create'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.templates.create',
            ])->name('email-templates.create');
    
            Route::post('email-templates/create', [TemplateController::class, 'store'])->defaults('_config', [
                'redirect' => 'email-templates.index',
            ])->name('email-templates.store');
    
            Route::get('email-templates/edit/{id}', [TemplateController::class, 'edit'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.templates.edit',
            ])->name('email-templates.edit');
    
            Route::post('email-templates/edit/{id}', [TemplateController::class, 'update'])->defaults('_config', [
                'redirect' => 'email-templates.index',
            ])->name('email-templates.update');
    
            Route::post('email-templates/delete/{id}', [TemplateController::class, 'destroy'])->name('email-templates.delete');
    
            /**
             * Events routes.
             */
            Route::get('events', [EventController::class, 'index'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.events.index',
            ])->name('events.index');
    
            Route::get('events/create', [EventController::class, 'create'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.events.create',
            ])->name('events.create');
    
            Route::post('events/create', [EventController::class, 'store'])->defaults('_config', [
                'redirect' => 'events.index',
            ])->name('events.store');
    
            Route::get('events/edit/{id}', [EventController::class, 'edit'])->defaults('_config', [
                'view' => 'admin::marketing.email-marketing.events.edit',
            ])->name('events.edit');
    
            Route::post('events/edit/{id}', [EventController::class, 'update'])->defaults('_config', [
                'redirect' => 'events.index',
            ])->name('events.update');
    
            Route::post('events/delete/{id}', [EventController::class, 'destroy'])->name('events.delete');
    
        });

        Route::prefix('sales')->group(function () {
            /**
             * Orders routes.
             */
            Route::get('/orders', [OrderController::class, 'index'])->defaults('_config', [
                'view' => 'admin::sales.orders.index',
            ])->name('sales.orders.index');
    
            Route::get('/orders/view/{id}', [OrderController::class, 'view'])->defaults('_config', [
                'view' => 'admin::sales.orders.view',
            ])->name('sales.orders.view');
    
            Route::get('/orders/cancel/{id}', [OrderController::class, 'cancel'])->defaults('_config', [
                'view' => 'admin::sales.orders.cancel',
            ])->name('sales.orders.cancel');
    
            Route::post('/orders/create/{order_id}', [OrderController::class, 'comment'])->name('sales.orders.comment');
    
            /**
             * Invoices routes.
             */
            Route::get('/invoices', [InvoiceController::class, 'index'])->defaults('_config', [
                'view' => 'admin::sales.invoices.index',
            ])->name('sales.invoices.index');
    
            Route::get('/invoices/create/{order_id}', [InvoiceController::class, 'create'])->defaults('_config', [
                'view' => 'admin::sales.invoices.create',
            ])->name('sales.invoices.create');
    
            Route::post('/invoices/create/{order_id}', [InvoiceController::class, 'store'])->defaults('_config', [
                'redirect' => 'sales.orders.view',
            ])->name('sales.invoices.store');
    
            Route::get('/invoices/view/{id}', [InvoiceController::class, 'view'])->defaults('_config', [
                'view' => 'admin::sales.invoices.view',
            ])->name('sales.invoices.view');
    
            Route::post('/invoices/send-duplicate/{id}', [InvoiceController::class, 'sendDuplicateInvoice'])
                ->name('sales.invoices.send-duplicate-invoice');
    
            Route::get('/invoices/print/{id}', [InvoiceController::class, 'printInvoice'])->defaults('_config', [
                'view' => 'admin::sales.invoices.print',
            ])->name('sales.invoices.print');
    
            Route::get('/invoices/{id}/transactions', [InvoiceController::class, 'invoiceTransactions'])
                ->name('sales.invoices.transactions');
    
            /**
             * Refunds routes.
             */
            Route::get('/refunds', [RefundController::class, 'index'])->defaults('_config', [
                'view' => 'admin::sales.refunds.index',
            ])->name('sales.refunds.index');
    
            Route::get('/refunds/create/{order_id}', [RefundController::class, 'create'])->defaults('_config', [
                'view' => 'admin::sales.refunds.create',
            ])->name('sales.refunds.create');
    
            Route::post('/refunds/create/{order_id}', [RefundController::class, 'store'])->defaults('_config', [
                'redirect' => 'sales.orders.view',
            ])->name('sales.refunds.store');
    
            Route::post('/refunds/update-qty/{order_id}', [RefundController::class, 'updateQty'])->defaults('_config', [
                'redirect' => 'sales.orders.view',
            ])->name('sales.refunds.update_qty');
    
            Route::get('/refunds/view/{id}', [RefundController::class, 'view'])->defaults('_config', [
                'view' => 'admin::sales.refunds.view',
            ])->name('sales.refunds.view');
    
            /**
             * Transactions routes.
             */
            Route::get('/transactions', [TransactionController::class, 'index'])->defaults('_config', [
                'view' => 'admin::sales.transactions.index',
            ])->name('sales.transactions.index');
    
            Route::get('/transactions/create', [TransactionController::class, 'create'])->defaults('_config', [
                'view' => 'admin::sales.transactions.create',
            ])->name('sales.transactions.create');
    
            Route::post('/transactions/create', [TransactionController::class, 'store'])->name('sales.transactions.store');
    
            Route::get('/transactions/view/{id}', [TransactionController::class, 'view'])->defaults('_config', [
                'view' => 'admin::sales.transactions.view',
            ])->name('sales.transactions.view');
        });
    });
});
