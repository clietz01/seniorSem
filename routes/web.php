<?php

use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [userController::class, 'login']);
Route::post('/submit', [postController::class, 'storePost']);
Route::post('/register', [userController::class, 'register']);