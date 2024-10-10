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
        /*
        $incomingfields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        */
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
            return view('profile')->with('success', 'You are now logged in!')->with('user', auth()->user());

        }else {
            return redirect('/')->with('failure', 'Incorrect Login!');
        }
    }


    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out!')->withInput();
    }

    public function showProfile(){
        return view('profile');
    }

}
