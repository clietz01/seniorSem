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
        <h1>{{$post->title}}</h1>
        <p>{{$post->body}}</p>
        <form action="/return/{{$post->user->id}}">
            <button type="submit">Back to Profile</button>
        </form>
    </body>
    </html>
</x-layout>