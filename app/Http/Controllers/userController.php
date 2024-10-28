<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth;

class userController extends Controller
{
    //
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }
    
        $incomingfields = $validator->validated();

        $incomingfields['password'] = bcrypt($incomingfields['password']);

        User::create($incomingfields);

        //log user in after registering 
        session()->regenerate();
        return redirect('/')->with('success', 'Registration Successful!');
    }

    public function login(Request $request){

        $incomingfields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['name' => $incomingfields['loginusername'], 
                             'password' => $incomingfields['loginpassword']
                             ])){

            session()->regenerate();
            $user = auth()->user()->load(['posts']); // Eager load relationships
            $postCount = $user->posts()->count(); //get amount of user posts
            $channels = $user->posts->pluck('channel')->unique(); //find channels user has posted to

            return view('profile', [
                'success' => 'You are now logged in!',
                'user' => $user,
                'posts' => $user->posts, 
                'postCount' => $postCount,
                'channels' => $channels
            ]);

        }else {
            return redirect('/')->with('failure', 'Incorrect Login!');
        }
    }


    public function logout(){
        auth()->logout();
        return redirect('/')->with('login_success', 'You are now logged out!')->withInput();
    }
    
    public function showProfile(User $user){

        $posts = $user->posts()->latest()->get();
        $postCount = $user->posts()->count();
        $channels = $user->posts->pluck('channel')->unique();

        return view('profile', [
            'user' => $user,
            'posts' => $posts,
            'postCount' => $postCount,
            'channels' => $channels
        ]);
    }

}
