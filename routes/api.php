<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReasearchController;
use App\Http\Controllers\TagController;

Route::post('/auth/login', [AuthController::class, "Login"]);
Route::post('/auth/logout', [AuthController::class, "Logout"])->middleware('auth:api');
Route::get('/auth/whoami', [AuthController::class, "WhoAmI"])->middleware('auth:api');

Route::get('/forum', [ForumController::class, "Search"]);
Route::post('/forum', [ForumController::class, "Create"])->middleware('auth:api');
Route::get('/forum/{Id}', [ForumController::class, "Detail"]);
Route::post('/forum/{Id}/commend', [ForumController::class, "CommendAdd"])->middleware('auth:api');

Route::get('/research', [ReasearchController::class, "Search"]);
Route::post('/research', [ReasearchController::class, "Create"])->middleware('auth:api');
Route::get('/research/{Id}', [ReasearchController::class, "Detail"])->middleware('auth:api');
Route::post('/research/{Id}/timeline', [ReasearchController::class, "TimelineCreate"])->middleware('auth:api');

Route::get('/tag', [TagController::class, "Search"]);
Route::post('/tag/request', [TagController::class, "RequestAdd"])->middleware('auth:api');
