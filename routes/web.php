<?php

use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

Route::get('/', function () {
    return view('welcome');
});

//userController routes
Route::post('/register', [userController::class, 'register'])->name('register');
Route::post('/login', [userController::class, 'login'])->name('login');
Route::post('/logout', [userController::class, 'logout']);
Route::get('/return/{user}', [userController::class, 'showProfile']);

//postController routes
Route::post('/submit', [postController::class, 'storePost']);
Route::get('/posts/{post}', [postController::class, 'show']);
Route::get('/mainPage', [postController::class, 'createPost']);

//threadController routes