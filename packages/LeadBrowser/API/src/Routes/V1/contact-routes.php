<?php

use Illuminate\Support\Facades\Route;
use LeadBrowser\API\Http\Controllers\V1\Organization\OrganizationController;
use LeadBrowser\API\Http\Controllers\V1\Organization\EmployeeController;

Route::group([
    'prefix'     => 'contacts',
    'middleware' => 'auth:sanctum',
], function () {
    /**
     * Employee routes.
     */
    Route::get('employees', [EmployeeController::class, 'index']);

    Route::get('employees/{id}', [EmployeeController::class, 'show']);

    Route::get('employees/search', [EmployeeController::class, 'search']);

    Route::post('employees', [EmployeeController::class, 'store']);

    Route::put('employees/{id}', [EmployeeController::class, 'update']);

    Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);

    Route::post('employees/mass-destroy', [EmployeeController::class, 'massDestroy']);

    /**
     * Organization routes.
     */
    Route::get('organizations', [OrganizationController::class, 'index']);

    Route::get('organizations/{id}', [OrganizationController::class, 'show']);

    Route::post('organizations', [OrganizationController::class, 'store']);

    Route::put('organizations/{id}', [OrganizationController::class, 'update']);

    Route::delete('organizations/{id}', [OrganizationController::class, 'destroy']);

    Route::post('organizations/mass-destroy', [OrganizationController::class, 'massDestroy']);
});
