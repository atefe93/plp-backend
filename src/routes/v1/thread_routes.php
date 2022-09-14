<?php

use App\Http\Controllers\API\v1\Thread\AnswerController;
use App\Http\Controllers\API\v1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;

Route::apiResource('threads', ThreadController::class);
Route::prefix('/threads')->group(function () {
    Route::apiResource('answers', AnswerController::class);
});
