<x-layout :user="Auth::user()">
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Channels</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>



    <body>
        <h1>Choose a Channel to post in. Or Make One!</h1>
        <div class="comment">
            <h3>Existing Channels:</h3>
            <ul>
                @foreach ($channels as $channel)
                    <li><a href="/channels/{{$channel->id}}">{{$channel->title}}</a></li>
                @endforeach
            </ul>
            <button onclick="getLocation()">Check Location</button>
        </div>
        <p id="demo"></p>
        <hr>
        <div class="comment">
            <h2>Create a Channel!</h2>
            <form action="/createChannel" id="channel_creation" method="POST">
                @csrf
                <label for="name">Channel Title</label>
                <input type="text" name="title">
                <label for="slogan">Channel Slogan</label>
                <input type="text" name="slogan">
                <label for="description">Channel Description</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                <button type="submit">Create Channel</button>
            </form>
        </div>
        <script>
            /*
            const x = document.getElementById("demo");
            function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            }

            function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
            }
            */

            navigator.geolocation.getCurrentPosition(position => {
                const {latitude, longitude} = position.coords;

                fetch('/channels/location', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ latitude, longitude})
                })
                .then(response = response.json())
                .then(channels => {
                    let channelList = document.getElementById('channel-list');
                    channelList.innerHTML = '';


                    channels.array.forEach(channel => {
                        let li = document.createElement('li');
                        li.textContent = channel.name;
                        channelList.appendChild(li);
                    });
                });
            }, error => {
                console.error("Geolocation Error: ", error);
            });
        </script>
    </body>
    </html>
</x-layout>
