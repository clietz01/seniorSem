<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
        <title>Post</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <h1 id="post-title">{{$post->title}}</h1>
        <div id="timestamp"><p>Created {{$post->created_at}}</p></div>
        @if(auth()->check() && auth()->user()->id == $post->user_id)
            <div id="post-container">
                <p id="post-body">{{$post->body}}</p>
                <button id="edit-post-button" data-post-id="{{$post->id}}">Edit Post</button>
                <div id="repost-button"></div>
            </div>
            @else
            <p id="post-body">{{$post->body}}</p>
            <a href="/reply/{{$post->id}}"><button id="reply-button">Reply</button></a>
        @endif
        <hr>
        <h3>Replies:</h3>
        @if(auth()->check() && auth()->user()->id == $post->user_id)
        @if ($replies->isEmpty())
            <h3>Your post has no replies yet!</h3>
        @else
            <ul>
                @foreach ($replies as $reply)
                    <li>{{$reply->content}}</li>
                @endforeach
            </ul>
        @endif
        @else
            @if ($replies->isEmpty())
                <h3>This post has no replies yet!</h3>
                <p>Help add to this masterpiece!</p>
            @else
            <ul>
                @foreach ($replies as $reply)
                    <li><p>{{$reply->content}}</p> <p>Created {{$reply->created_at}}</p></li>
                @endforeach
            </ul>
            @endif
        @endif
        <div id="reply-container" data-post-id="{{$post->id}}"></div> <!--Where replies will be displayed -->
        <hr>
        <form action="/return/{{$post->user->id}}">
            <button type="submit">Back to Profile</button>
        </form>

        <form action="/channels/{{$post->channel_id}}">
            <button type="submit">Back to <strong>{{$post->channel->title}}</strong></button>
        </form>

        <script src="{{asset('js/view-post.js')}}"></script>
    </body>
    </html>
</x-layout>
