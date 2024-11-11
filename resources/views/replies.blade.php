<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Replies</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>
    <body>
        <div id="timestamp">
            <p>Post created {{$post->created_at}}</p>
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
                    <li class="comment">
                        <div class="comment-content">
                            <p>{{$reply->content}}</p> <div id="timestamp"> <p>{{$reply->created_at}}</p> </div><a href="#"><button>Reply</button></a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </body>
    </html>
</x-layout>