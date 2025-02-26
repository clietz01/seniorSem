<x-layout :user="Auth::user()">
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Channels</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>



    <body>
        <h1>Find a Local Channel:</h1>
        <div class="comment">
            <h3>Channels in Your Area:</h3>
            <ul id="channel-list">
                @foreach ($channels as $channel)
                    <li><a href="/channels/{{$channel->id}}">{{$channel->title}}</a></li>
                @endforeach
            </ul>
            <button onclick="getLocation()">Check Location</button>
        </div>
        <p id="demo"></p>
        <hr><br>
        <h1>Or Make One!</h1>
        <div class="comment">
            <h2>Create a Local Channel!</h2>
            <h3>This channel will only be available at your current position.</h3>
            <form action="/createChannel" id="channel_creation" method="POST">
                @csrf
                <label for="title">Channel Title</label>
                <input type="text" name="title">
                <label for="slogan">Channel Slogan</label>
                <input type="text" name="slogan">
                <label for="radius">Visibility Radius (km):</label>
                <input type="number" id="radius" name="radius" min="1" max="100" required>
                <label for="description">Channel Description</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>

                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">

                <button type="submit">Create Channel</button>
            </form>
            <p id="status-message"></p>
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


            document.getElementById('channel_creation').addEventListener('submit', function(event) {

                event.preventDefault();
                if (!navigator.geolocation){
                    alert("Geolocation is not supported by your browser.");
                    return;
                }

                navigator.geolocation.getCurrentPosition(position => {

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    const formData = new FormData(this);

                    fetch('/createChannel', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('status-message').innerText = data.message;
                    })
                    .catch(error => console.error('Error: ', error));
                }, error => {
                    alert("Unable to retrieve your location");
                });

            });

            document.addEventListener("DOMContentLoaded", function() {

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            navigator.geolocation.getCurrentPosition(position => {
                const {latitude, longitude} = position.coords;

                fetch('/channels/location', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ latitude, longitude})
                })
                .then(response => response.json())
                .then(channels => {
                    let channelList = document.getElementById('channel-list');
                    channelList.innerHTML = '';

                    if (channels.length == 0){
                        channelList.innerHTML = "<li>No Channels found in your area.</li>";
                    }

                    channels.forEach(channel => {
                        let li = document.createElement('li');
                        let a = document.createElement('a');
                        a.href = "/channels/" + channel.id;
                        a.textContent = channel.name;
                        li.appendChild(a);
                        channelList.appendChild(li);
                    });
                }).catch(error => console.error("Error fetching channels: ", error));
            }, error => {
                console.error("Geolocation Error: ", error);
            });
        });

        </script>
    </body>
    </html>
</x-layout>
