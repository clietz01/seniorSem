
<x-layout :user="Auth::user()">
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Replies</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="main-content">
            <div id="post-header-container">
                <div id="post-header">
                <div style="background-color: #2d2d2d; padding: 10px; margin-bottom: 20px;">
                    <a href="/posts/{{ $post->id }}" id="title-back-link">
                        <h1 style="margin-top: 10px; margin-bottom: -15px; ">{{ $post->title }}</h1>
                    </a>
                        <div id="timestamp">
                            <h3>Post created {{ $post->created_at }} by User</h3>
                        </div>
                        <p class="display-name">
                            <span
                            class="hashed_name"
                            data-user-id="{{ $post->user->id }}"
                            data-username="{{ $post->anonymous_username }}"
                            data-user-pic="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile-pic.jpg') }}"
                            data-user-likes="{{ $post->user->posts->sum('likes') }}"
                                style="color: rebeccapurple">
                                {{ $post->anonymous_username ?? 'Anonymous'}}
                            </span>
                        </p>
                        <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile-pic.jpg') }}"
                     alt="User's Profile Picture"
                     style="width: 40px; height: 40px; border-radius: 50%;">
                    <h3>{{ $post->body }}</h3>
                </div>
                    <div id="likes" style="margin-bottom: 20px;">{{$post->likes}} ❤️</div>
                </div>
            </div>
            <div id="reply-container">
                <div id="actual-replies">
                    <h2>Reply to post:</h2>
                    <form action="{{ route('createReply', $post->id) }}" method="POST">
                        @csrf
                        <textarea name="content" id="reply-box" cols="50" rows="10"></textarea>
                        <button type="submit">Post</button>
                    </form>
                    <div id="current-replies">
                        <ul>
                            @foreach ($replies as $reply)
                                @include('partials.replies', ['reply' => $reply, 'anonymousUsername'=> $reply->anonymousUsername])
                            @endforeach
                        </ul>
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
            <img src="" id="preview-pfp"
                    alt="User's Profile Picture"
                    style="width: 60%; height: 100%; border-radius: 3px;">
            </div>
            <button id="preview-exit">🡨</button>
        </div>

        <script src="{{ asset('js/edit-reply.js') }}"></script>
        <script src="{{ asset('js/reply-to-reply.js') }}"></script>
        <script src="{{ asset('js/peek-profile.js') }}"></script>
    </body>
    </html>
</x-layout>
