<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\User;

class userController extends Controller
{
    //
    public function seePost(){
        return view('submit');
    }


    public function register(Request $request){
        $incomingfields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        $incomingfields['password'] = bcrypt($incomingfields['password']);

        User::create($incomingfields);

        return 'hello bro';
    }

    public function login(Request $request){

        $incomingfields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingfields['loginusername'], 
                             'password' => $incomingfields['loginpassword']
                             ])){

            return 'Congrats!!!';

        }else {
            return 'DIE!!!!';
        }
    }
}
