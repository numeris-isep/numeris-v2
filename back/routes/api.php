<?php

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

use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::post('subscribe', 'Auth\AuthController@subscribe')->name('subscribe');
Route::post('password/forgot', 'Auth\ForgotPasswordController@forgot')->name('password.forgot');
Route::post('password/reset', 'Auth\ResetPasswordController@doReset')->name('password.reset');

// Contact us
Route::post('contact-us', 'ContactUsController@contactUs')->name('contact-us');

// Every route in this group require user authentication
Route::group(['middleware' => 'auth:api'], function () {

    // Verify Email routes
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::get('email/verify', 'Auth\VerificationController@verify')->middleware('signed')->name('verification.verify');

    // Auth routes
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');
    Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
    Route::post('current-user', 'Auth\AuthController@currentUser')->name('current-user');

    // User resource routes
    Route::apiResource('users', 'UserController', ['parameters' => ['users' => 'user_id']])->except(['store']);
    Route::patch('users/{user_id}/terms-of-use', 'UserController@updateTermsOfUse')->name('users.update.terms-of-use');
    Route::patch('users/{user_id}/activated', 'UserController@updateActivated')->name('users.update.activated');
    Route::get('users-promotion', 'UserController@indexPromotion')->name('users.index.promotion');
    Route::apiResource('users.applications', 'UserApplicationController', ['parameters' => ['users' => 'user_id']])
        ->only(['index', 'store']);

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
    Route::get('clients/{client_id}/projects', 'ClientProjectController@index')->name('clients.projects.index');
    Route::get('clients/{client_id}/conventions', 'ClientConventionController@index')->name('clients.conventions.index');
    Route::post('clients/{client_id}/conventions', 'ClientConventionController@store')->name('clients.conventions.store');

    // Convention resource routes
    Route::apiResource('conventions', 'ConventionController', ['parameters' => ['conventions' => 'convention_id']])
        ->only(['show', 'update', 'destroy']);

    // Contact resource routes
    Route::apiResource('contacts', 'ContactController', ['parameters' => ['contacts' => 'contact_id']]);

    // Project resource routes
    Route::apiResource('projects', 'ProjectController', ['parameters' => ['projects' => 'project_id']]);
    Route::get('projects-steps', 'ProjectController@indexStep')->name('projects.steps.index');
    Route::get('projects/{project_id}/missions', 'ProjectMissionController@index')->name('projects.missions.index');
    Route::apiResource('projects.users', 'ProjectUserController')
        ->only(['index', 'store', 'destroy']);
    Route::patch('projects/{project_id}/step', 'ProjectController@updateStep')->name('projects.update.step');
    Route::patch('projects/{project_id}/payment', 'ProjectController@updatePayment')->name('projects.update.payment');
    Route::put('projects/{project_id}/invoices', 'ProjectInvoiceController@update')->name('projects.invoices.update');

    // Mission resource routes
    Route::apiResource('missions', 'MissionController', ['parameters' => ['missions' => 'mission_id']]);
    Route::get('missions-available', 'MissionController@indexAvailable')->name('missions.index.available');
    Route::post('missions/{mission_id}/email', 'MissionController@sendPreMissionEmail')->name('missions.email');
    Route::post('missions/notify', 'MissionController@notifyAvailability')->name('missions.notify');
    Route::patch('missions/{mission_id}/lock', 'MissionController@updateLock')->name('missions.update.lock');
    Route::apiResource('missions.applications', 'MissionApplicationController', ['parameters' => ['missions' => 'mission_id']])
        ->only(['index', 'store']);
    Route::get('missions/{mission_id}/users', 'MissionUserController@indexNotApplied')->name('missions.users.index.not-applied');
    Route::put('missions/{mission_id}/bills', 'MissionBillController@update')->name('missions.bills.update');

    // Application resource routes
    Route::post('applications', 'ApplicationController@index')->name('applications.index');
    Route::get('applications-statuses', 'ApplicationController@indexStatus')->name('applications.statuses.index');
    Route::apiResource('applications', 'ApplicationController', ['parameters' => ['applications' => 'application_id']])
        ->only(['update', 'destroy']);

    // Payslip resource routes
    Route::post('payslips', 'PayslipController@index')->name('payslips.index');
    Route::put('payslips', 'PayslipController@update')->name('payslips.update');
    Route::patch('payslips', 'PayslipController@updatePartial')->name('payslips.update.partial');
    Route::get('payslips/{payslip_id}/download-payslip', 'PayslipController@downloadPayslip')
        ->name('payslips.download.payslip');
    Route::get('payslips/{payslip_id}/download-contract', 'PayslipController@downloadContract')
        ->name('payslips.download.contract');
    Route::put('payslips/download-zip', 'PayslipController@downloadZip')
        ->name('payslips.download.zip');

    // Invoice resource routes
    Route::post('invoices', 'InvoiceController@index')->name('invoices.index');
    Route::get('invoices/{invoice_id}/download', 'InvoiceController@download')
        ->name('invoices.download');

    // Message ressource routes
    Route::get('messages/current', 'MessageController@current')->name('message.current');
    Route::patch('messages/{message_id}/activation', 'MessageController@updateActivated')->name('message.updateActivated');
    Route::apiResource('messages', 'MessageController', ['parameters' => ['messages' => 'message_id']]);


});

// Payslip resource routes
Route::put('payslips-podium', 'PayslipController@indexPodium')->name('payslips.podium.index');
