<?php
use Appchat\Chat\Http\Controllers\ChatController;
use AppUser\User\Http\Middleware\Authenticate;


Route::group([
    'prefix' => 'chat',
    'middleware' => Authenticate::class
], function () {

    Route::get('users', [ChatController::class, 'allUsers']);
    Route::post('create', [ChatController::class, 'create']);
    Route::post('send', [ChatController::class, 'send']);
    Route::post('react', [ChatController::class, 'react']);
    Route::post('reply', [ChatController::class, 'reply']);
    Route::post('all-chats', [ChatController::class, 'allChats']);
    Route::post('open-chat', [ChatController::class, 'openChat']);

});