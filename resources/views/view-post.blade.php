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
        <div id="main-content">
            <div id="pretty-post-container">
                <div class="comment" style="width: 90%;">
                    <div style="background-color: #2d2d2d; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        <h1 id="post-title">{{$post->title}}</h1>
                            <p>Created <span style="color: red">{{$post->created_at}}</span> by User <span class="hashed_name"
                            data-user-id="{{ $post->user->id }}"
                            data-username="{{ $post->anonymous_username }}"
                            data-user-pic="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile-pic.jpg') }}"
                            data-user-likes="{{ $post->user->posts->sum('likes') }}"
                                style="color: rebeccapurple">
                                {{$post->anonymousUsername}}
                                </span>
                            </p>
                            <img id="pfp-bubble" src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile-pic.jpg') }}"
                            alt="User's Profile Picture"
                            style="width: 40px; height: 40px; border-radius: 50%;">
                        @if(auth()->check() && auth()->user()->id == $post->user_id)
                            <div id="post-container">
                                <h3 id="post-body">{{$post->body}}</h3>
                            </div>
                    </div>
                        <div id="post-options">
                            <span class="like-count">{{ $post->likes ?? 0 }}</span> ❤️
                                <button id="edit-post-button" data-post-id="{{$post->id}}">Edit Post</button>
                                <a href="/posts/delete/{{$post->id}}"><button id="delete-post-button">Delete Post</button></a>
                                <div id="repost-button"></div>
                        </div>
                        @else
                        <h3 id="post-body">{{$post->body}}</h3>
                        <div style="display: inline-block">
                            <button class="like-btn" data-post-id="{{ $post->id }}">
                                <span class="like-count">{{ $post->likes ?? 0 }}</span> ❤️
                            </button>
                        </div>
                        <a href="/reply/{{$post->id}}"><button id="reply-button">Reply</button></a>
                    @endif
                </div>
            </div>
            <div id="others-for-post">
                <div id="reply-options">
                    <div class="comment">
                        <form action="/return/{{$post->user->id}}">
                            <button type="submit">Back to Profile</button>
                        </form>
                        <form action="/channels/{{$post->channel_id}}">
                            <button type="submit">Back to <strong>{{$post->channel->title}}</strong></button>
                        </form>
                    </div>
                    <div style="background-color: #333333; border-radius: 5px; padding: 10px">
                        <h2>Replies:</h2>
                        <hr>
                        @if(auth()->check() && auth()->user()->id == $post->user_id)
                        @if ($replies->isEmpty())
                            <h3>Your post has no replies yet!</h3>
                        @else
                            <ul>
                                @foreach ($replies->take(5) as $reply)
                                    <li><p>{{
                                    strlen($reply->content) >= 50 ? substr($reply->content, 0, 50) . "..." : $reply->content
                                    }}</p></li>
                                @endforeach
                            </ul>
                        @endif
                        @else
                            @if ($replies->isEmpty())
                                <h3>This post has no replies yet!</h3>
                                <p>Help add to this masterpiece!</p>
                            @else
                            <ul>
                                @foreach ($replies->take(5) as $reply)
                                    <li>

                                            <p>{{strlen($reply->content) >= 50 ? substr($reply->content, 0, 50) . "..." : $reply->content}}</p>

                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        @endif
                        <a href="/reply/{{$post->id}}"><button>See All {{ $post->replies->count() }} Replies</button></a>
                    </div>
                </div>
            </div>
        </div>



        <div id="profile-preview">
            <div>
                <h3 id="preview-usr"></h3>
                <hr>
            </div>
            <div id="preview-visuals">
            <h3 id="preview-likes"></h3>
            <img id="preview-pfp" src=""
                    alt="User's Profile Picture"
                    style="width: 60%; height: 100%; border-radius: 3px;">
            </div>
            <button id="preview-exit">🡨</button>
        </div>

        <script src="{{asset('js/view-post.js')}}"></script>
        <script src="{{ asset('js/peek-profile.js') }}"></script>
        <script>

     document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('profile-preview').style.display = "none";
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
