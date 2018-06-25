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

});


