<?php

use AppBlog\Blog\Http\Controllers\BlogsController;

Route::group([
    'prefix' => 'api/v1'
], function () {
    Route::get('blogs', [BlogsController::class, 'index']);
    Route::get('blogs/{id}', [BlogsController::class, 'show']);
});