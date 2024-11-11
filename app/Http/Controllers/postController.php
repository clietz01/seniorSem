<?php

namespace App\Http\Controllers;

use App\Models\channel;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\reply;
use Illuminate\Support\Facades\Redirect;

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

        $replies = $newPost->reply()->get();

        return view('/view-post', [
            'post' => $newPost,
            'channel_id' => $channel->id,
            'replies' => $replies
        ]);
    }

    public function createPost(){

        return view('mainPage');

    }

    public function show(Post $post){

        $replies = $post->reply()->get();

        return view('view-post', [

            'post' => $post,
            'replies' => $replies
        ]);
    }


    public function update(Request $request, post $post){
        
        $request->validate(
            [
                'body' => 'required|string'
                
                ]
        );

        $post->body = $request->input('body');
        $post->save();
        

        return response()->json(['success' => true]);
    }


    public function deletePost(post $post){

        $destination = $post->channel;
        $post->delete();

        return Redirect::to($destination->path());
    }


    public function replyPage(post $post){

        $replies = $post->reply()->get();

       return view('replies', [

        'post' => $post,
        'replies' => $replies

       ]);

    }


    public function createReply(Request $request, post $post){

        $incoming_fields = $request->validate([
            'content' => 'required|string'
        ]);

        $incoming_fields['content'] = strip_tags($incoming_fields['content']);
        $incoming_fields['user_id'] = auth()->id();

        $newReply = reply::create([
            'content' => $incoming_fields['content'],
            'user_id' => $incoming_fields['user_id'],
            'post_id' => $post->id
        ]);

        return redirect()->route('replyPage', $post->id);
    }

}
    