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

    public function getChannelsByLocation(Request $request){

        $userLat = $request->input('latitude');
        $userLng = $request->input('longitude');

        if (!$userLat || !$userLng){

            return response()->json(['error' => 'Location is required'], 400);
        }

        $channels = Channel::all()->filter(function ($channel) use ($userLat, $userLng){
            return $channel->isWithinRadius($userLat, $userLng);
        });

        return response()->json($channels);

    }






    public function channelScreen(){

        $channels = channel::all();

        return view('channels', [
            'channels' => $channels
        ]);

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
            #'user_id' => auth()->id() // Explicitly include user_id
        ]);

        $this->ensureAnonymousUsername($newChannel->id);


        return view('view-channel', [
            'channel' => $newChannel,
            'posts' => $newChannel->post()->latest()->get()
        ]);

    }

    public function viewChannel(channel $channel){

        $this->ensureAnonymousUsername($channel->id);

        // Eager load related data
        $posts = $channel->post()->with('channel.users')->latest()->get();

        foreach ($posts as $post) {
            \Log::info('Post Debug', [
                'post_id' => $post->id,
                'user_id' => $post->user_id,
                'channel_id' => $post->channel_id,
                'anonymousUsername' => $post->anonymousUsername ?? 'N/A',
            ]);
        }

        $postCount = $channel->post()->count();

        $user = Auth::user();
        $anonymousUsername = $user->channels()
            ->where('channel_id', $channel->id)
            ->first()
            ->pivot
            ->anonymous_username;

        return view('view-channel', [
            'channel' => $channel,
            'posts' => $posts,
            'postcount' => $postCount,
            'anonymousUsername' => $anonymousUsername,
        ]);
    }


    private function ensureAnonymousUsername($channelId){
    $user = Auth::user();

    // Check if anonymous username already exists
    $existingPivot = $user->channels()->where('channel_id', $channelId)->exists();

    if (!$existingPivot) {
        // Generate a unique anonymous name
        $anonymousUsername = hash_hmac(
            'sha256',
            $user->id . $channelId . config('app.key'), // Unique data
            config('app.key') // Use app key for hashing
        );

        // Attach the user to the channel with the anonymous username
        $user->channels()->attach($channelId, ['anonymous_username' => $anonymousUsername]);
    }
}
}
