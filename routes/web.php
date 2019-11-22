<?php

// Welcome
Route::view('/', 'welcome');
// Authentication
Auth::routes();
// Home
Route::get('home', 'HomeController@index')->name('home');
// Document
Route::put('documents/{document}/approval', 'DocumentApprovalController')->name('documents.approval');
Route::resource('documents', 'DocumentController');
// Module Management
Route::resource('module-workflows', 'ModuleWorkflowController');
// Workflow Management
Route::resource('workflows', 'WorkflowController')->except('create');
Route::resource('workflows.workflow-steps', 'WorkflowStepController')->only(['store', 'update', 'destroy']);
// User Management
Route::resource('users', 'UserController');
// Role Management
Route::resource('roles', 'RoleController');
