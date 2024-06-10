<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmployersController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/user')->namespace('User')->group(function() {

    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('logout', [UserController::class, 'logout']);

});

Route::prefix('/employer')->namespace('User')->group(function() {

    Route::post('register', [EmployersController::class, 'register']);
    Route::post('login', [EmployersController::class, 'login']);
    Route::get('logout', [EmployersController::class, 'logout']);

});