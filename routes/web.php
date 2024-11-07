<?php

use App\Http\Controllers\channelController;
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
//Route::post('/submit', [postController::class, 'storePost']);
Route::get('/posts/{post}', [postController::class, 'show']);
Route::put('/posts/{post}', [postController::class, 'update']);
Route::get('/mainPage', [postController::class, 'createPost']);
Route::post('/channels/{channel}/posts', [postController::class, 'storePost'])->name('posts.store');
Route::post('/reply/{post}', [postController::class, 'reply']);

//channelController routes
Route::get('/channel', [channelController::class, 'channelScreen']);
Route::post('/createChannel', [channelController::class, 'createChannel']);
Route::get('/channels/{channel}', [channelController::class, 'viewChannel']);
