<?php

use AppUser\User\Http\Controllers\UserController;
use AppUser\User\Http\Middleware\Authenticate;

Route::group([
    'prefix' => 'api/v1'
], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
});


Route::group(['middleware' => Authenticate::class], function () {
    Route::get('/test', function () {
        return 'Hello world';
    });
});