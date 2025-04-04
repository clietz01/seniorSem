<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome Page</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    </head>
    <body>
        <h1 id="channel_slogan">What's On Your Mind?</h1>
        <form action="/submit" method="POST" id="mainPost">
            @csrf
            <label for="title">Title</label>
            <input type="text" name="title">
            <label for="body">Body</label>
            <textarea name="body" id="userInput" rows="10" cols="50">Share something!</textarea>
            <button type="submit">Post</button>
        </form>
    </body>
    </html>
</x-layout>
