<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'namespace' => 'Result\Http\Controllers'], function() {

    
    Route::group(['prefix' => 'v1/core'], function () {
        Route::group(['prefix' => 'exports'], function() {
            Route::get('results/{slug}', 'ResultController@export');
        });
    });

    Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
        Route::resource('results', 'ResultController');
    });

});