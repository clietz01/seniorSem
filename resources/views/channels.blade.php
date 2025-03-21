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
        <style>
            #map {
                height: 400px; /* The height is 400 pixels */
                width: 100%; /* The width is the width of the web page */
            }
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
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
        </div>
        <p id="demo"></p>
        <hr><br>
        <h1>Or Make One!</h1>
        <div id="channel-creation-container">
            <!--
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
                    <input type="number" id="radius" name="radius" min="0.1" max="100" required step="any">
                    <label for="description">Channel Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <button type="submit">Create Channel</button>
                </form>
                <p id="status-message"></p>
            </div>
        -->
            <div class="comment" id="map-view">
                <h2>Choose a Location:</h2>
                <h3>Once created, a channel will only be available once you are within its range.</h3>
                <div id="map"><img src="" alt=""></div>
                <div id="map-selection-menu">
                    <div id="selectionDetails">
                        <h3>Create Channel Here:</h3>
                        <h4 id="map-coords"></h4>
                    </div>

                    <a id="reset-pos"><button>Reset Marker</button></a>

                    <form action="/createChannel" method="POST" id="channel_creation">
                        @csrf
                        <label for="title">Channel Title</label>
                        <input type="text" name="title">
                        <label for="slogan">Channel Slogan</label>
                        <input type="text" name="slogan">
                        <label for="radius">Visibility Radius (km):</label>
                        <span id="radiusValue"></span>
                        <input type="range" id="radiusSlider" name="radius" min="100" max="50000" step="0.1" oninput="updateRadius(this.value)">
                        <label for="description">Channel Description</label>
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>

                        <!-- Hidden fields to store selected coordinates -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <button type="submit">Create Channel</button>
                    </form>
                    <p id="status-message"></p>
                </div>
            </div>
        </div>

        <script src="{{ asset("js/googMapsAPI.js") }}"></script>
        <script>

            let channelList = document.getElementById('channel-list');
            let fetchedChannels = [];


            document.getElementById('channel_creation').addEventListener('submit', function(event) {

                event.preventDefault();
                if (!navigator.geolocation){
                    alert("Geolocation is not supported by your browser.");
                    return;
                }

                    //console.log("user position found: ", latitude, longitude);

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

                        //add new channel to the stored channelList
                        fetchedChannels.push(data.channel);
                        updateChannelList();
                    })
                    .catch(error => console.error('Error: ', error));


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
                    console.log("Fetched Channels: ", channels)
                    fetchedChannels = channels;
                    updateChannelList();


                }).catch(error => console.error("Error fetching channels: ", error));
            }, error => {
                console.error("Geolocation Error: ", error);
            });
        });


        function updateChannelList(){

            console.log("Updating channel list...", fetchedChannels);
            channelList.innerHTML = '';

            if (fetchedChannels.length == 0){
                    channelList.innerHTML = "<li>No Channels found in your area.</li>";
                    return;
                }


            fetchedChannels.forEach(channel => {

                let li = document.createElement('li');
                let a = document.createElement('a');
                a.href = "/channels/" + channel.id;
                a.textContent = channel.title;
                li.appendChild(a)
                channelList.appendChild(li);
            })

            console.log("Final Channel List: ", channelList);
        }

        </script>
    </body>
    </html>
</x-layout>
