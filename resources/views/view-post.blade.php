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
    </body>
    </html>
</x-layout>