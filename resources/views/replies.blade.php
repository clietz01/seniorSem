
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
        <div id="post-header">
            <div id="timestamp">
                <p>Post created {{ $post->created_at }} by User</p>
            </div>
            <p class="display-name">{{ $post->anonymous_username ?? 'Anonymous'}}</p>
            <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile-pic.jpg') }}" 
         alt="User's Profile Picture" 
         style="width: 40px; height: 40px; border-radius: 50%;">
        </div>
        <a href="/posts/{{ $post->id }}" id="title-back-link">
            <h1>{{ $post->title }}</h1>
        </a>
        <h3>{{ $post->body }}</h3>
        
        <hr>
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
        <script src="{{ asset('js/edit-reply.js') }}"></script>
        <script src="{{ asset('js/reply-to-reply.js') }}"></script>
    </body>
    </html>
</x-layout>
