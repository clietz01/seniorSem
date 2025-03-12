<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{secure_asset('css/styles.css')}}">
    <title>CityChat Support</title>
</head>
<body>
    <h1>Have a question or suggestion for the site? Let us know!</h1>
    <p>We will get back to you as soon as we can</p>

    <div class="complaints">
        <form action="/sendFeedback">
            <textarea name="feedback" id="feedback" cols="30" rows="10"></textarea>
	    <label for="insert_media">Send Media</label>
             <input type="file" name="insert_media" id="insert_media">
            <button type="submit">Submit</button>
        </form>

	<a href="/"><button>Back to Home</button></a>


    </div>
</body>
</html>
