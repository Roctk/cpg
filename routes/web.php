<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/notifications-test', function () {
    /** @var \App\Services\Notifications\DeviceNotificationsSender $sender */
    $sender = app(\App\Services\Notifications\DeviceNotificationsSender::class);
    $sender->sendNotification(['message' => 'test']);

    return 'success';
});

Route::get('/comments/', function () {
    return view('comments');
});