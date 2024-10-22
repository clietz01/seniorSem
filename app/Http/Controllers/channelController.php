<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\channel;
use Illuminate\Broadcasting\Channel as BroadcastingChannel;
use Illuminate\Support\Facades\Auth;
use App\Models\post;

class channelController extends Controller
{
    //
    public function channelScreen(){

        return view('channels');

    }

    public function createChannel(Request $request){

        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'slogan' => 'required'
            ]);

        $incomingFields['user_id'] = auth()->id();

        $newChannel = channel::create([
            'title' => $incomingFields['title'],
            'description' => $incomingFields['description'],
            'slogan' => $incomingFields['slogan'],
            'user_id' => auth()->id() // Explicitly include user_id
        ]);

        return view('view-channel', [
            'channel' => $newChannel,
            'posts' => $newChannel->post()->latest()->get()
        ]);

    }

    public function viewChannel(channel $channel){
        $posts = $channel->post()->latest()->get(); 
        $postCount = $channel->post()->count();

        return view('view-channel', [
            'channel' => $channel,
            'posts' => $posts,
            'postcount' => $postCount
        ]);
    }
}
