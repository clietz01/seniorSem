<?php

use App\Http\Controllers\channelController;
use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\feedbackController;
use App\Models\post;



//support
Route::get('/support', function(){
	return view('supportPage');
})->name('supportPage');


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
Route::post('/posts/{post}/like', [postController::class, 'likePost'])->middleware('auth');
Route::post('/posts/location', [postController::class, 'getPostsByLocation']);

//channelController routes
Route::get('/channel', [channelController::class, 'channelScreen']);
Route::post('/channels/location', [channelController::class, 'getChannelsByLocation']);
Route::post('/createChannel', [channelController::class, 'createChannel'])->name('channels.create');
Route::get('/channels/{channel}', [channelController::class, 'viewChannel'])->name('channels.show');


//email auth
Route::get('/email/verify', function (Request $request) {

    if (!$request->user()->hasVerifiedEmail()) {
        $request->user()->sendEmailVerificationNotification();
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/')->with('message', 'Account Verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');




//support Controller routes

Route::get('/feedback', [feedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback/send', [feedbackController::class, 'sendFeedback'])->name('feedback.send');
Route::get('/support', function () {
    return view('supportPage');
})->name('support');
