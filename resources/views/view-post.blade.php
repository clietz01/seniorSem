<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
        <title>Post</title>
    </head>
    <body>
        <h1 id="post-title">{{$post->title}}</h1>
        <p id="post-body">{{$post->body}}</p>
        @if(auth()->check() && auth()->user()->id == $post->user_id)
            <button id="edit-post-button">Edit Post</button>
        @endif
        <form action="/return/{{$post->user->id}}">
            <button type="submit">Back to Profile</button>
        </form>

        <form action="/channels/{{$post->channel_id}}">
            <button type="submit">Back to Channel</button>
        </form>
    </body>
    </html>
</x-layout>