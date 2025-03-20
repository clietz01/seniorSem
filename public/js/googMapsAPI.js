document.addEventListener('DOMContentLoaded', () => {

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
            let map;


            async function initMap() {
            var defaultRadius = 5000;
            const position = { lat: latitude, lng: longitude };
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
                title: "Current Location",
            });


            let circle = new google.maps.Circle({

                map: map,
                center: position,
                radius: defaultRadius,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2

            });

            document.getElementById("latitude").value = position.lat;
            document.getElementById("longitude").value = position.lng;

            document.getElementById("radiusSlider").value = defaultRadius;
            document.getElementById("radiusValue").innerText = defaultRadius / 1000 + "km";

            mapSelection = document.getElementById("map-coords");

            mapSelection.innerHTML = "Latitude: " + marker.position.lat + ", Longitude: " + marker.position.lng;

            map.addListener('click', (e) => {

                marker.position = e.latLng;
                marker.title = "Selected Location";
                circle.setCenter(e.latLng);

                //update hidden input fields with new coordinates
                document.getElementById("latitude").value = e.latLng.lat();
                document.getElementById("longitude").value = e.latLng.lng();

                mapSelection.innerHTML = "Latitude: " + marker.position.lat + ", Longitude: " + marker.position.lng;
            });
            window.updateRadius = function(value) {
                var radiusInMeters = parseInt(value);
                if (circle) {
                    circle.setRadius(radiusInMeters);
                    document.getElementById("radiusValue").innerText = (radiusInMeters / 1000) + " km";
                }
            };

            document.getElementById("reset-pos").addEventListener("click", () => {

                marker.position = position;
                marker.title = "Current Location";
                circle.setCenter(position);
                mapSelection.innerHTML = "Latitude: " + marker.position.lat + ", Longitude: " + marker.position.lng;
            });


            }

            initMap();

    });


});
