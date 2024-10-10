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
        <form action="/mainPage" method="GET">
            <input type="submit">
        </form>
        <h3>Your posts:</h3>
    </body>
    </html>
</x-layout>