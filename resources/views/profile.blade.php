<x-layout :user="Auth::user()">
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
        <div class="comment">
            <h1>User Profile: <div class="display-name">{{$user->name}}</div></h1>
            <div class="profile-container">
                <div id="profile-options">
                    <form action="/profile" method="GET">
                        <button type="submit">Edit Profile</button>
                    </form>
                    <form action="/channel" method="GET">
                        <button type="submit">Make a Post!</button>
                    </form>
                </div>
                <div id="profile-shtuff">
                    @if ($user->profile_picture)
                        <img id="profile-pic" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                    @else
                        <img id="profile-pic" src="{{ asset('images/default-profile-pic.jpg') }}" alt="Default Profile Picture">
                    @endif
                </div>
            </div>
            <div class="comment">
                <div id="user_posts">
                    <h3>Your posts: [{{$postCount}}]</h3>
                    <ul>
                        @if ($posts->isEmpty())
                            <h3>You have no posts!</h3>
                        @else
                        @foreach ($posts as $post)
                            <li><a href="/posts/{{$post->id}}">{{$post->title}}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div id="user_channels">
                    <h3>Channels you've posted to:</h3>
                    <ul>
                        @if($channels->isEmpty())
                            <h3>You haven't posted to any Channels yet.</h3>
                        @else
                            @foreach ($channels as  $channel)
                                <li><a href="/channels/{{$channel->id}}">{{$channel->title}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </body>
    </html>
</x-layout>
