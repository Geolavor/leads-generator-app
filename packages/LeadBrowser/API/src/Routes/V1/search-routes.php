<?php

use Illuminate\Support\Facades\Route;
use LeadBrowser\API\Http\Controllers\V1\Search\SearchLocationsController;

Route::group([
    'prefix' => 'search',
    'middleware' => 'auth:sanctum'
], function () {

        Route::get('locations', [SearchLocationsController::class, 'index']);
        Route::get('locations/{id}', [SearchLocationsController::class, 'show']);
        Route::post('locations', [SearchLocationsController::class, 'store']);
        Route::put('locations/{id}', [SearchLocationsController::class, 'update']);
        Route::delete('locations/{id}', [SearchLocationsController::class, 'destroy']);
});
