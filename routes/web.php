<?php

use App\Http\Controllers\channelController;
use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Models\post;

Route::get('/', function () {
    return view('welcome');
});

//userController routes
Route::post('/register', [userController::class, 'register'])->name('register');
Route::post('/login', [userController::class, 'login'])->name('login');
Route::post('/logout', [userController::class, 'logout']);
Route::get('/return/{user}', [userController::class, 'showProfile']);
Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile', [UserController::class, 'updateProfilePicture'])->name('profile.updatePicture');

//postController routes
//Route::post('/submit', [postController::class, 'storePost']);
Route::get('/posts/{post}', [postController::class, 'show']);
Route::put('/posts/{post}', [postController::class, 'update']);
Route::get('/mainPage', [postController::class, 'createPost']);
Route::post('/channels/{channel}/posts', [postController::class, 'storePost'])->name('posts.store');
Route::get('/reply/{post}', [postController::class, 'replyPage'])->name('replyPage');
Route::post('/{post}/createReply', [postController::class, 'createReply'])->name('createReply');
Route::get('/posts/delete/{post}', [postController::class, 'deletePost']);
Route::put('/posts/replies/{reply}', [postController::class, 'updateReply']);
Route::post('/replies/{reply}/reply', [postController::class, 'storeNestedReply'])->name('nestedReply');

//channelController routes
Route::get('/channel', [channelController::class, 'channelScreen']);
Route::post('/createChannel', [channelController::class, 'createChannel']);
Route::get('/channels/{channel}', [channelController::class, 'viewChannel'])->name('channels.show');
