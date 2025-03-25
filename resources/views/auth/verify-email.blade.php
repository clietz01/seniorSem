<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div id="verification-container">
        <div id="verification-content">
            <h1>Verify Your Email Address</h1>
            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
            <br>
            @if (session('message'))
                <div class="alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <br>
            <p style="margin-bottom: 5%">If you didn't receive the email, click below to request another.</p>
            <br>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">Resend Verification Email</button>
            </form>
        </div>
    </div>
</body>
</html>
