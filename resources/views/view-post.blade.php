<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
        <title>Post</title>
    </head>
    <body>
        <h1 id="post-title">{{$post->title}}</h1>
        <p id="post-body">{{$post->body}}</p>
        @if(auth()->check() && auth()->user()->id == $post->user_id)
            <button id="edit-post-button">Edit Post</button>
            @else
            <button id="reply-button">Reply</button>
        @endif
        <hr>
        <h3>Replies:</h3>
        @if ($replies->isEmpty())
            <h3>This post has no replies yet!</h3>
            <p>Let them know what you think!</p>
        @endif
        <hr>
        <form action="/return/{{$post->user->id}}">
            <button type="submit">Back to Profile</button>
        </form>

        <form action="/channels/{{$post->channel_id}}">
            <button type="submit">Back to <strong>{{$post->channel->title}}</strong></button>
        </form>
    </body>
    </html>
</x-layout>