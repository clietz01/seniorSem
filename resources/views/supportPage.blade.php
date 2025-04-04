<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <title>CityChat Support</title>
</head>
<body>
    <div id="support-container">
        <div class="inner-support-container">
        <h1>Have a question or suggestion for the site? Let us know!</h1>
        <p>We will get back to you as soon as we can</p>
        <h2>Send Feedback</h2>
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('feedback.send') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Feedback</button>
        </form>
        @auth
            <a href="/return/{{ auth()->id() }}"><button style="margin: 20px 20px;">Return to Profile</button></a>
            @else
            <a href="/"><button style="margin: 20px 20px">Return to Login</button></a>
        @endauth
        </div>
    </div>


</body>
</html>
