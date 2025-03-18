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
            <div class="comment" id="map-view">
                <h2>Choose a Location:</h2>
                <h3>Once created, a channel will only be available once you are within its range.</h3>
                <div id="map"><img src="" alt=""></div>
                <div id="map-selection-menu">
                    <h3>Create Channel Here:</h3>
                    <h4 id="map-coords"></h4>
                    <form action="#" method="POST">
                        <button type="submit">Create Channel</button>
                    </form>
                </div>
            </div>
        </div>

        <script>

            let channelList = document.getElementById('channel-list');
            let fetchedChannels = [];


            document.getElementById('channel_creation').addEventListener('submit', function(event) {

                event.preventDefault();
                if (!navigator.geolocation){
                    alert("Geolocation is not supported by your browser.");
                    return;
                }

                navigator.geolocation.getCurrentPosition(position => {

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    console.log("user position found: ", latitude, longitude);

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

                        //add new channel to the stored channelList
                        fetchedChannels.push(data.channel);
                        updateChannelList();
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


                 //maps API
                 (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
                key: "AIzaSyCBmIL_F09jGX25KejsG-BmjyzLzG2Mvbc",
                v: "weekly",
                // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
                // Add other bootstrap parameters as needed, using camel case.
            });

                // Initialize and add the map
                // Initialize and add the map
                let map;

                async function initMap() {
                // The location of Uluru
                const position = { lat: latitude, lng: longitude };
                // Request needed libraries.
                //@ts-ignore
                const { Map } = await google.maps.importLibrary("maps");
                const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

                // The map, centered at Uluru
                map = new Map(document.getElementById("map"), {
                    zoom: 4,
                    center: position,
                    mapId: "DEMO_MAP_ID",
                });

                // The marker, positioned at Uluru
                const marker = new AdvancedMarkerElement({
                    map: map,
                    position: position,
                    title: "Current Location",
                });
                }

                initMap();
            //end of maps API


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
