<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Jwt auth routes
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::post('logout', 'Auth\AuthController@logout')->name('logout');
Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
Route::post('current-user', 'Auth\AuthController@currentUser')->name('current-user');

// Every route in this group require user authentication
Route::group(['middleware' => 'auth:api'], function () {

    // User resource routes
    Route::apiResource('users', 'UserController', ['parameters' => ['users' => 'user_id']]);
    Route::patch('users/{user_id}/profile', 'UserController@updateProfile')->name('users.update.profile');
    Route::patch('users/{user_id}/terms-of-use', 'UserController@updateTermsOfUse')->name('users.update.terms-of-use');

    // Role resource routes
    Route::get('roles', 'RoleController@index')->name('roles.index');

    // UserRole resource routes
    Route::apiResource('users.roles', 'UserRoleController', ['parameters' => [
        'users' => 'user_id',
        'roles' => 'role_id',
    ]])->only(['index', 'store']);

    // Preference resource routes
    Route::put('preferences/{preference_id}', 'PreferenceController@update')->name('preferences.update');

    // Client resource routes
    Route::apiResource('clients', 'ClientController', ['parameters' => ['clients' => 'client_id']]);

    // Convention resource routes
    Route::post('clients/{client_id}/conventions', 'ClientConventionController@store')->name('clients.conventions.store');

    Route::apiResource('conventions', 'ConventionController', ['parameters' => ['conventions' => 'convention_id']])
        ->only(['update', 'destroy']);

    // Rate resource routes
    Route::apiResource('conventions.rates', 'ConventionRateController', ['parameters' => ['conventions'   => 'convention_id']])
        ->only(['store']);

    Route::apiResource('rates', 'RateController', ['parameters' => ['rates' => 'rate_id']])
        ->only(['update', 'destroy']);

    // Project resource routes
    Route::apiResource('projects', 'ProjectController', ['parameters' => ['projects' => 'project_id']]);

    Route::patch('projects/{project_id}/step', 'ProjectController@updateStep')->name('projects.update.step');

    Route::patch('projects/{project_id}/payment', 'ProjectController@updatePayment')->name('projects.update.payment');

    // Mission resource routes
    Route::apiResource('missions', 'MissionController', ['parameters' => ['missions' => 'mission_id']]);

    Route::patch('missions/{mission_id}/lock', 'MissionController@updateLock')->name('missions.update.lock');

    // Application resource routes
    Route::post('missions/{mission_id}/applications', 'MissionApplicationController@store')->name('missions.applications.store');

    Route::apiResource('users.applications', 'UserApplicationController', ['parameters' => ['users' => 'user_id']])
        ->only(['index', 'store']);

    Route::apiResource('applications', 'ApplicationController', ['parameters' => ['applications' => 'application_id']])
        ->only(['update', 'destroy']);

});


