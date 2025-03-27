<?php

namespace App\Http\Controllers;

use App\Models\channel;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\reply;
use App\Models\PostLike;
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
            'channel_id' => $channel->id,
            'likes' => 0
        ]);

        $replies = $newPost->replies()->get();

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

        $replies = $post->replies()->whereNull('parent_id')->get();
        $post->load(['user', 'replies.user', 'replies.replies.user']);

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



    public function likePost(Request $request, $postId){
  // Check if user is authenticated
        if (!auth()->check()) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

        $post = Post::findOrFail($postId);
        $user = auth()->user();

        // Check if the user already liked this post
        $existingLike = PostLike::where('post_id', $postId)->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Unlike: Delete the like entry and decrement the like count
            $existingLike->delete();
            $post->decrement('likes');

            return response()->json([
                'liked' => false,
                'likes' => $post->likes
            ]);
        } else {
            // Like: Insert into post_likes and increment the like count
            PostLike::create(['post_id' => $postId, 'user_id' => $user->id]);
            $post->increment('likes');

            return response()->json([
                'liked' => true,
                'likes' => $post->likes
            ]);
        }

    }



    public function deletePost(post $post){

        $destination = $post->channel;
        $post->delete();

        return Redirect::to($destination->path());
    }


    public function replyPage(post $post){

        $post->load(['user', 'replies.user', 'replies.replies.user']);

    $replies = $post->replies()->whereNull('parent_id')->get();

    function assignAnonymousUsername($reply, $post)
    {
        // Assign anonymous username
        $reply->anonymousUsername = $post->channel
            ->users()
            ->where('users.id', $reply->user_id)
            ->first()
            ->pivot
            ->anonymous_username ?? 'Anonymous';

        // Assign profile picture
        $reply->profilePicture = $reply->user->profile_picture
            ? secure_asset('storage/' . $reply->user->profile_picture)
            : secure_asset('images/default-profile-pic.jpg');

        // Recursively process all replies
        if ($reply->replies->isNotEmpty()) {
            $reply->replies = $reply->replies->map(function ($nestedReply) use ($post) {
                return assignAnonymousUsername($nestedReply, $post);
            });
        }

        return $reply;
    }

    // Apply function recursively to all replies
    $replies = $replies->map(function ($reply) use ($post) {
        return assignAnonymousUsername($reply, $post);
    });

    return view('replies', [
        'post' => $post,
        'replies' => $replies
    ]);
    }


    public function createReply(Request $request, post $post){

        $incoming_fields = $request->validate([
            'content' => 'required|string'
        ]);

        $incoming_fields['content'] = strip_tags($incoming_fields['content']); //prevent malicious user injection
        $incoming_fields['user_id'] = auth()->id();

        $newReply = reply::create([
            'content' => $incoming_fields['content'],
            'user_id' => $incoming_fields['user_id'],
            'post_id' => $post->id
        ]);

        return redirect()->route('replyPage', $post->id);
    }


    public function updateReply(Request $request, reply $reply){

        $request->validate([
            'content' => 'required|string'
        ]);

        $reply->content = $request['content'];
        $reply->save();

        return response()->json([
            'success' => true,
            'message' => "Reply updated successfully!"

        ]);
    }

    public function storeNestedReply(Request $request, Reply $reply)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $newReply = $reply->replies()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'post_id' => $reply->post_id
        ]);

        return response()->json([
            'id' => $newReply->id,
            'content' => $newReply->content,
            'created_at' => $newReply->created_at->toDateTimeString(),
            'user' => [
                'id' => $newReply->user->id,
                'name' => $newReply->user->name,
            ],
        ]);
    }

    public function getPostsByLocation(Request $request){
        try {
            $userLat = $request->input('latitude');
            $userLng = $request->input('longitude');

            if (!$userLat || !$userLng) {
                return response()->json(['error' => 'Location is required'], 400);
            }

            // Use the provided radius or default values
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

            \Log::info("User Location:", ['latitude' => $userLat, 'longitude' => $userLng]);

            // Use the Haversine Formula to calculate distance
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

            // Log each channel with its computed distance for debugging
            foreach ($channels as $channel) {
                \Log::info("Channel Found: ", [
                    'id' => $channel->id,
                    'title' => $channel->title,
                    'distance' => $channel->distance,
                    'radius' => $channel->radius
                ]);
            }

            // Filter channels manually by comparing the distance to the channel's radius
            $filteredChannels = $channels->filter(function ($channel) {
                return floatval($channel->distance) <= floatval($channel->radius);
            })->values();

            \Log::info("Filtered Channels: ", ['channels' => $filteredChannels->toArray()]);

            // Retrieve the target user ID.
            // You can either get it from the request or use the authenticated user's ID.
            // For example, if it's provided in the request:
            $targetUserId = $request->input('userId');
            // Or, if you want to use the logged-in user, uncomment the following line:
            // $targetUserId = auth()->id();

            // Query posts from those filtered channels that belong to the specific user
            $posts = Post::whereIn('channel_id', $filteredChannels->pluck('id'))
                ->where('user_id', $targetUserId)
                ->get();

            return response()->json($posts);

        } catch (\Exception $e) {
            \Log::error("Error in getChannelsByLocation: " . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

}
