<?php

use App\Http\Controllers\API\v1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;

Route::apiResource('threads', ThreadController::class);
