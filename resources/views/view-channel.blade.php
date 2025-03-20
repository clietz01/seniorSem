<x-layout :user="Auth::user()">
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Channel</title>
        <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    </head>
    <body>
        <div class="comment">
            <div id="channel-header">
                <div class="comment">
                    <h1>Welcome to <div id="channel_title">{{$channel->title}}</div></h1>
                    <div id="hiddenData">
                        <p id="chan-lat">{{ $channel->latitude }}</p>
                        <p id="chan-lng">{{ $channel->longitude }}</p>
                        <p id="rad">{{ $channel->radius }}</p>
                    </div>
                    <div id="options">
                        <h3>{{$channel->description}}</h3>
                    </div>
                    <a href="/channel"><button>Return to Channel Selection</button></a>
                </div>
                <div class="comment">
                <div id="map"></div>
                </div>
            </div>
        </div>
        <hr>
        <h2>Posts in {{$channel->title}}:</h2>
        <ul>
            @if ($posts->isEmpty())
                <h3>This Channel is empty!</h3>
                <h4>Help by adding a post!</h4>
            @else
            @foreach ($posts as $post)
                <li><a href="/posts/{{$post->id}}">{{$post->title}}</a></li>
            @endforeach
            @endif
        </ul>
        <hr>
        <div class="comment">
            <h2>Add a post to <div id="channel_title">{{$channel->title}}</div></h2>
            <h1 id="channel_slogan">{{$channel->slogan}}</h1>
            <form action="{{secure_url( route('posts.store', ['channel' => $channel->id]))}}" method="POST" id="mainPost">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title">
                <label for="body">Body</label>
                <textarea name="body" id="userInput" rows="10" cols="50">Share something!</textarea>
                <button type="submit">Post</button>
            </form>
        </div>
        <script>

            document.addEventListener('DOMContentLoaded', () => {
                 //maps API
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "AIzaSyCBmIL_F09jGX25KejsG-BmjyzLzG2Mvbc",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });
        let map;


            async function initMap() {


                const lat = parseFloat(document.getElementById("chan-lat").innerText);
                const lng = parseFloat(document.getElementById("chan-lng").innerText);
                const chanRadius = parseFloat(document.getElementById("rad").innerText);

                if (isNaN(lat) || isNaN(lng) || isNaN(chanRadius)) {
                    console.error("Invalid channel data: ", { lat, lng, chanRadius });
                    return;
                }

                const position = {lat: lat, lng: lng};
            // Request needed libraries.
            //@ts-ignore
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 12,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Channel Location",
            });


            let circle = new google.maps.Circle({

                map: map,
                center: position,
                radius: chanRadius,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2

            });
        }

        initMap();
            });

        </script>
    </body>
    </html>
</x-layout>
