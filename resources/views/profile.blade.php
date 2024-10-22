<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Profile</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>
    <body>
        <h1>Welcome back, {{$user->name}}</h1>
        <form action="/channel" method="GET">
            <button type="submit">Make a Post!</button>
        </form>
        <div id="user_posts">
            <h3>Your posts:</h3>
            <ul>
                @if ($posts->isEmpty())
                    <h3>You have no posts!</h3>
                @else
                @foreach ($posts as $post)
                    <li><a href="/posts/{{$post->id}}">{{$post->title}}</a></li>
                @endforeach
                @endif
            </ul>
        </div>
        <div id="user_channels">
            <h3>Your Channels:</h3>
        </div>
    </body>
    </html>
</x-layout>