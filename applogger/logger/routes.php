<?php

use AppLogger\Logger\Models\Log;
use AppUser\User\Http\Middleware\Authenticate;
use Illuminate\Support\Carbon;
use AppLogger\Logger\Http\Controllers\LogController;

Route::group([
    'prefix' => 'api/v1',
    'middleware' => Authenticate::class
], function () {
    Route::post('log/create', [LogController::class, 'create']);
    Route::post('log/index', [LogController::class, 'index']);
    Route::post('log/show', [LogController::class, 'show']);
});