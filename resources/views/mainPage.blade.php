<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>
<body>
    <h1>What's On Your Mind?</h1>
    <form action="/submit" method="POST">
        @csrf
        <input type="text" name="title">
        <textarea name="post" id="userInput" rows="10" cols="50">
        </textarea>
        <button type="submit">Post</button>
    </form>
</body>
</html>