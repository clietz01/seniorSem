<x-layout :user="Auth::user()">
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
        <div class="comment">
            <h1 id="post-title">{{$post->title}}</h1>
            <div id="timestamp"><p>Created {{$post->created_at}} by User {{$post->anonymousUsername}}</p></div>
            @if(auth()->check() && auth()->user()->id == $post->user_id)
                <div id="post-container">
                    <p id="post-body">{{$post->body}}</p>
                    <button id="edit-post-button" data-post-id="{{$post->id}}">Edit Post</button>
                    <a href="/posts/delete/{{$post->id}}"><button id="delete-post-button">Delete Post</button></a>
                    <div id="repost-button"></div>
                </div>
                @else
                <p id="post-body">{{$post->body}}</p>
                <a href="/reply/{{$post->id}}"><button id="reply-button">Reply</button></a>
            @endif
        </div>
        <hr>
        <h3>Replies:</h3>
        @if(auth()->check() && auth()->user()->id == $post->user_id)
        @if ($replies->isEmpty())
            <h3>Your post has no replies yet!</h3>
        @else
            <ul>
                @foreach ($replies as $reply)
                    <li><p>{{$reply->content}}</p></li>
                @endforeach
            </ul>
        @endif
        @else
            @if ($replies->isEmpty())
                <h3>This post has no replies yet!</h3>
                <p>Help add to this masterpiece!</p>
            @else
            <ul>
                @foreach ($replies->take(3) as $reply)
                    <li>
                        <div class="comment-content">
                            <p>{{$reply->content}} Created</p> <div id="timestamp"><p>{{$reply->created_at}}</p></div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @endif
        @endif
        <a href="/reply/{{$post->id}}"><button>See All Replies</button></a>
        <hr>
        <div class="comment">
            <form action="/return/{{$post->user->id}}">
                <button type="submit">Back to Profile</button>
            </form>
            <form action="/channels/{{$post->channel_id}}">
                <button type="submit">Back to <strong>{{$post->channel->title}}</strong></button>
            </form>
        </div>

        <script src="{{asset('js/view-post.js')}}"></script>
    </body>
    </html>
</x-layout>
