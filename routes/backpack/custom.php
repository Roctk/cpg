<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('course', 'CourseCrudController');
    CRUD::resource('adv', 'AdvCrudController');
    CRUD::resource('cleaning', 'CleaningCrudController');
    CRUD::resource('tech', 'TechCrudController');
    CRUD::resource('supply', 'SupplyCrudController');
    Route::get('/cleaning/{id}/comments', 'CleaningCrudController@showComments')->name('cleaning.comments');
    Route::post('/cleaning/{id}/comments', 'CleaningCrudController@saveComment');
    Route::get('/tech/{id}/comments', 'TechCrudController@showComments')->name('tech.comments');
    Route::post('/tech/{id}/comments', 'TechCrudController@saveComment');
    Route::get('/supply/{id}/comments', 'TechCrudController@showComments')->name('supply.comments');
    Route::post('/supply/{id}/comments', 'TechCrudController@saveComment');
}); // this should be the absolute last line of this file