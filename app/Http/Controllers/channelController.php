<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\channel;
use Illuminate\Broadcasting\Channel as BroadcastingChannel;
use Illuminate\Support\Facades\Auth;
use App\Models\post;
use Exception;

class channelController extends Controller
{
    //

    public function getChannelsByLocation(Request $request){

        try {
            $userLat = $request->input('latitude');
            $userLng = $request->input('longitude');

            if (!$userLat || !$userLng) {
                return response()->json(['error' => 'Location is required'], 400);
            }

        $maxRadius = $request->input('radius') ?? Channel::max('radius') ?? 10;
        \DB::enableQueryLog();

        $earthRadius = 6371; // Earth radius in km

        // Calculate bounding box to optimize the search
        $latDiff = rad2deg($maxRadius / $earthRadius);
        $lngDiff = rad2deg($maxRadius / ($earthRadius * cos(deg2rad($userLat))));

        $minLat = $userLat - $latDiff;
        $maxLat = $userLat + $latDiff;
        $minLng = $userLng - $lngDiff;
        $maxLng = $userLng + $lngDiff;

        // Log user coordinates for debugging
        \Log::info("User Location:", ['latitude' => $userLat, 'longitude' => $userLng]);

            // Haversine Formula to filter nearby channels
            $channels = Channel::selectRaw("
    id, title, slogan, description, latitude, longitude, radius,
    (6371 * acos(
    cos(radians(?)) * cos(radians(latitude))
    * cos(radians(longitude - ?))
    + sin(radians(?)) * sin(radians(latitude))
    )) AS distance
    ", [$userLat, $userLng, $userLat])
        ->whereBetween('latitude', [$minLat, $maxLat])
        ->whereBetween('longitude', [$minLng, $maxLng])
        ->orderBy('distance', 'asc')
        ->get();

        \Log::info("Final SQL Query: ", [
            'query' => \DB::getQueryLog()
        ]);


            // Log each channel with its computed distance
            foreach ($channels as $channel) {
            \Log::info("Channel Found: ", [
                'id' => $channel->id,
                'title' => $channel->title,
                'distance' => $channel->distance,
                'radius' => $channel->radius
            ]);
        }

        // Filter within the distance range manually in PHP
        $filteredChannels = $channels->filter(function ($channel) {
            return floatval($channel->distance) <= floatval($channel->radius);
        })->values();


        \Log::info("Filtered Channels: ", ['channels' => $filteredChannels->toArray()]);

        return response()->json($filteredChannels);


        } catch (\Exception $e) {
            \Log::error("Error in getChannelsByLocation: " . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }

    }






    public function channelScreen(){

        $channels = channel::all();

        return view('channels', [
            'channels' => $channels
        ]);

    }

    public function createChannel(Request $request){
        /*
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
        */

        try {

        $request->validate([
            'title' => 'required|string|max:255',
            'slogan' => 'string|max:255',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:0.1'
        ]);

        $channel = Channel::create([
            'title' => $request->title,
            'slogan' => $request->slogan,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius / 1000
        ]);

        //return redirect('/channel')->with( ['message' => 'Channel created successfully', 'channel' => $channel]);

        return response()->json(['message' => 'Channel created successfully', 'channel' => $channel]);

    } catch (Exception $e){
        \Log::error("Error in createChannel: " . $e->getMessage());
    }

    return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);

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
