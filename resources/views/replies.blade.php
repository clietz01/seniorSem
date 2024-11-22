<!-- 
<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Replies</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="post-header">
            <div id="timestamp">
                <p>Post created {{$post->created_at}} by </p>
            </div>
            <p class="display-name">{{$post->user->name}}</p>
        </div>
        <a href="/posts/{{$post->id}}" id="title-back-link">
            <h1>{{$post->title}}</h1>
        </a>
        <h3>{{$post->body}}</h3>
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
                    @if (auth()->check() && $reply->user_id == auth()->user()->id)
                    <li class="comment">
                        <div class="comment-content">
                            <div class="comment-header">
                                <p>Created by</p> <p class="display-name">{{$reply->user->name}}</p>
                            </div>
                            <div id="comment-body-container">
                                <div class="comment-body"><p>{{$reply->content}}</p>
                                </div> <div id="timestamp"> <p>{{$reply->created_at}}</p></div>
                                <button class="edit-reply-button" data-edit-id="{{$reply->id}}">Edit Reply</button>
                            </div>
                        </div>
                        <div class="reply-replies-container">

                        </div>
                    </li>
                    
                    @else
                    <li class="comment">
                        <div class="comment-content">
                            <div class="comment-header">
                                <p>Created by</p> <p class="display-name">{{$reply->user->name}}</p>
                            </div>
                            <div id="comment-body-container">
                                <div class="comment-body"><p>{{$reply->content}}</p></div>
                                <div id="timestamp"> <p>{{$reply->created_at}}</p></div>
                                <button class="reply-reply-button" data-reply-Id="{{$reply->id}}">Reply</button>
                            </div>
                        </div>
                        <div class="reply-replies-container">

                        </div>
                    </li>
                    
                    @endif
                @endforeach
            </ul>
        </div>
        <script src="{{asset('js/edit-reply.js')}}"></script>
        <script src="{{asset('js/reply-to-reply.js')}}"></script>
    </body>
    </html>
</x-layout>
-->

<x-layout>
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
                <p>Post created {{ $post->created_at }} by </p>
            </div>
            <p class="display-name">{{ $post->user->name }}</p>
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
                    @include('partials.replies', ['reply' => $reply])
                @endforeach
            </ul>
        </div>
        <script src="{{ asset('js/edit-reply.js') }}"></script>
        <script src="{{ asset('js/reply-to-reply.js') }}"></script>
    </body>
    </html>
</x-layout>
