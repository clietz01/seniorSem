<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Welcome</title>
</head>
<body>
    <div id="main-container">
        <div id="setup-half">
            <div id="login">
                @if (session('login_success'))
                <div class="alert-success">{{ session('login_success') }}</div>
                @endif
                <h1>Been here before? Login now!</h1>
                <form action="{{ url('login') }}" method="POST">
                    @csrf
                    @if (session('failure'))
                    <div class="alert alert-danger">{{ session('failure') }}</div>
                    @endif
                    <input type="text" name="loginusername" placeholder="Username">
                    <input type="password" name="loginpassword" placeholder="Password">
                    <button type="submit">Login</button>
                </form>
            </div>
            <div id="signup">
                <h1>New Here? Sign up now!</h1>
                <form action="{{ url('register') }}" method="POST">
                    @csrf
                    @if (session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <input type="text" name="email" placeholder="Email">
                    <input type="text" name="name" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
        <div id="display-half">
            <h1>WELCOME TO CITYCHAT</h1>
            <p>A project by Christian Lietz</p>
        </div>
    </div>
    <footer>
        <ul>
            <li><a href="https://github.com/clietz01">Github</a></li>
            <li><a href="https://www.linkedin.com/in/christian-lietz-76a36822a/">LinkedIn</a></li>
            <li><a href="{{ route('support') }}">Support</a></li>
        </ul>
    </footer>
</body>
</html>
