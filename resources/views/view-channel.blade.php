<x-layout>
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
        <h1>Welcome to <div id="channel_title">{{$channel->title}}</div></h1>
        <p>{{$channel->description}}</p>
        <hr>
        <h2>Posts in {{$channel->title}}:</h2>
        <ul>
            @if ($posts->isEmpty())
                <h3>This Channel is empty!</h3>
                <h4>Help by adding a post!</h4>
            @else
            @foreach ($posts as $post)
                <li><a href="/posts/{{$post->id}}">{{$post->title}}</li>
            @endforeach
            @endif
        </ul>
        <a href="/"></a>
    </body>
    </html>
</x-layout>
