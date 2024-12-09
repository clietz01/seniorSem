<x-layout :user="Auth::user()">
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Channel</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>
    <body>
        <div class="comment">
            <h1>Welcome to <div id="channel_title">{{$channel->title}}</div></h1>
            <div id="options">
                <div class="comment">
                    <p>{{$channel->description}}</p>
                    <a href="/channel"><button>Return to Channel Selection</button></a>
                </div>
            </div>
        </div>
        <hr>
        <h2>Posts in {{$channel->title}}:</h2>
        <ul>
            @if ($posts->isEmpty())
                <h3>This Channel is empty!</h3>
                <h4>Help by adding a post!</h4>
            @else
            @foreach ($posts as $post)
                <li><a href="/posts/{{$post->id}}">{{$post->title}}</a></li>
            @endforeach
            @endif
        </ul>
        <hr>
        <div class="comment">
            <h2>Add a post to <div id="channel_title">{{$channel->title}}</div></h2>
            <h1 id="channel_slogan">{{$channel->slogan}}</h1>
            <form action="{{ route('posts.store', ['channel' => $channel->id]) }}" method="POST" id="mainPost">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title">
                <label for="body">Body</label>
                <textarea name="body" id="userInput" rows="10" cols="50">Share something!</textarea>
                <button type="submit">Post</button>
            </form>
        </div>
    </body>
    </html>
</x-layout>
