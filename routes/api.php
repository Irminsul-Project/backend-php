<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, "Login"]);
Route::get('/auth/whoami', [AuthController::class, "WhoAmI"])->middleware('auth:api');
