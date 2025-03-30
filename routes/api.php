<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;

Route::post('/auth/login', [AuthController::class, "Login"]);
Route::post('/auth/logout', [AuthController::class, "Logout"])->middleware('auth:api');
Route::get('/auth/whoami', [AuthController::class, "WhoAmI"])->middleware('auth:api');

Route::get('/forum', [ForumController::class, "Search"])->middleware('auth:api');
Route::post('/forum', [ForumController::class, "Create"])->middleware('auth:api');
Route::get('/forum/{Id}', [ForumController::class, "Detail"])->middleware('auth:api');
Route::post('/forum/{Id}/commend', [ForumController::class, "CommendAdd"])->middleware('auth:api');
