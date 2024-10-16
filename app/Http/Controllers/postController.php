<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\post;

class postController extends Controller
{
    //

    public function storePost(Request $request){
        $incoming_fields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incoming_fields['title'] = strip_tags($incoming_fields['title']);
        $incoming_fields['body'] = strip_tags($incoming_fields['body']);
        //^strips user input of malicious HTML
        $incoming_fields['user_id'] = auth()->id();//adds user_id to $incoming_fields array
        $newPost = post::create($incoming_fields);
        //dd($request->all()); <- debugging function

        return view('/view-post', ['post' => $newPost]);
    }

    public function createPost(){

        return view('mainPage');

    }

    public function show(Post $post){

        return view('view-post', ['post' => $post]);
    }

}
    