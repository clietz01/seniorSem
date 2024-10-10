    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
        <title>Welcome</title>
    </head>
    <body>

        @if (session('success'))
        <div class="alert-success">
            {{session('success')}}
        </div>
        @endif

        <h1>Been here before? Login now!</h1>
        <div id="login">
            <form action='/login' method="POST"> <!--Login -->
                @csrf
                @if (session('failure'))
                <div class="alert alert-danger">
                    {{ session('failure') }} <!--In case they get their login wrong-->
                </div>
                @endif
                <label for="loginusername">Username</label>
                <input type="text" name="loginusername"/>
                <label for="loginpassword">Password</label>
                <input type="password" name="loginpassword"/>
                <input type="submit"/>
            </form>
        </div>
        <br>
        <hr>
        <div id="signup">
            <h1>New Here? Sign up now!</h1> <!--Registration-->
            <form action="/register" method="POST">
                @csrf
                @if (session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
                @endif <!--Shows success message -->
    
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif <!-- Shows failure message-->
    
                <label for="email">Email</label>
                <input type="text" name="email">
    
                <label for="name">Username</label>
                <input type="text" name="name">
    
                <label for="password">Password</label>
                <input type="password" name="password">
    
                <label for="confirm">Confirm Password</label>
                <input type="password" name="password_confirmation">
                <input type="submit">
            </form>
        </div>
    </body>
    </html>