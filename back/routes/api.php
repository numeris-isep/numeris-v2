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

    // Address resource routes
    Route::apiResource('addresses', 'AddressController', ['parameters' => ['addresses' => 'address_id']]);

    // Preference resource routes
    Route::apiResource('preferences', 'PreferenceController', ['parameters' => ['preferences' => 'preference_id']]);

    // Role resource routes
    Route::get('roles', 'RoleController@index')->name('roles.index');

    // UserRole resource routes
    Route::resource('users.roles', 'UserRoleController', ['parameters' => [
        'users' => 'user_id',
        'roles' => 'role_id',
    ]])->except(['create', 'show', 'edit', 'update', 'destroy']);

    // Client resource routes
    Route::apiResource('clients', 'ClientController', ['parameters' => ['clients' => 'client_id']]);

    // Convention resource routes
    Route::post('clients/{client_id}/conventions', 'ClientConventionController@store')->name('clients.conventions.store');

    Route::resource('conventions', 'ConventionController', ['parameters' => ['conventions' => 'convention_id']])
        ->except(['index', 'create', 'store', 'show', 'edit']);

    // Project resource routes
    Route::apiResource('projects', 'ProjectController', ['parameters' => ['projects' => 'project_id']]);

});


