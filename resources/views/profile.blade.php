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
        <div id="profile-container">
            <div class="comment" id="profile-box">
                <h1 style="margin-bottom: 5%; background-color: #333333; border-radius: 5px; padding: 10px;">User Profile: <span style="color: red;">{{$user->name}}</span></h1>
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
                        <h2>Your posts: [{{$postCount}}]</h2>
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
                        <h2>Channels you've posted to:</h2>
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
                    <div id="user_likes">
                        <h2>Total Likes ❤: {{ $likes }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
</x-layout>
