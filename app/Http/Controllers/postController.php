<?php

namespace App\Http\Controllers;

use App\Models\channel;
use Illuminate\Http\Request;
use App\Models\post;

class postController extends Controller
{
    //

    public function storePost(Request $request, channel $channel){
        $incoming_fields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incoming_fields['title'] = strip_tags($incoming_fields['title']);
        $incoming_fields['body'] = strip_tags($incoming_fields['body']);
        //^strips user input of malicious HTML
        $incoming_fields['user_id'] = auth()->id();//adds user_id to $incoming_fields array
        $newPost = post::create([
            'title' => $incoming_fields['title'],
            'body' => $incoming_fields['body'],
            'user_id' => $incoming_fields['user_id'], // Include user_id here
            'channel_id' => $channel->id 
        ]);




        return view('/view-post', [
            'post' => $newPost,
            'channel_id' => $channel->id
        ]);
    }

    public function createPost(){

        return view('mainPage');

    }

    public function show(Post $post){

        return view('view-post', ['post' => $post]);
    }

}
    