<!DOCTYPE html>
<html>
<head>
    <title>Feedback from {{ $feedback['name'] }}</title>
</head>
<body>
    <h2>New Feedback Received</h2>
    <p><strong>Name:</strong> {{ $feedback['name'] }}</p>
    <p><strong>Email:</strong> {{ $feedback['email'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $feedback['message'] }}</p>
</body>
</html>
