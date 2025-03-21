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
                    <h3 id="post-body">{{$post->body}}</h3>
                </div>
                <div class="comment" id="post-options">
                    <span class="like-count">{{ $post->likes ?? 0 }}</span> ❤️
                        <button id="edit-post-button" data-post-id="{{$post->id}}">Edit Post</button>
                        <a href="/posts/delete/{{$post->id}}"><button id="delete-post-button">Delete Post</button></a>
                        <div id="repost-button"></div>
                </div>
                @else
                <p id="post-body">{{$post->body}}</p>
                <div class="comment">
                    <button class="like-btn" data-post-id="{{ $post->id }}">
                        <span class="like-count">{{ $post->likes ?? 0 }}</span> ❤️
                    </button>
                </div>
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
        <script>
     document.addEventListener("DOMContentLoaded", function () {
    let likeButtons = document.querySelectorAll(".like-btn");

    if (likeButtons.length > 0) {
        likeButtons.forEach(button => {
            button.addEventListener("click", function () {
                let postId = this.dataset.postId;
                let likeCountElem = this.querySelector(".like-count");

                fetch(`/posts/${postId}/like`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked !== undefined) {
                        likeCountElem.textContent = data.likes;
                    } else {
                        console.error("Unexpected response:", data);
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    } else {
        console.warn("No like buttons found on this page.");
    }
});
        </script>
    </body>
    </html>
</x-layout>
