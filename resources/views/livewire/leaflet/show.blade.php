<div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            width: 100%;
            height: 600px;
        }
        .form-container {
            margin: 20px 0;
        }
        label {
            margin-right: 10px;
        }
    </style>
    <div id="map"></div>
    <div class="form-container">
        <livewire:leaflet.create-device />
    </div>

    <script>
        // Use window-scoped variables to avoid redeclaration
        window.mapInstance = window.mapInstance || null;
        window.isListenerAttached = window.isListenerAttached || false;

        function initializeMap() {
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                console.error('Map container #map not found!');
                return;
            }

            // Clear existing map instance if it exists
            if (window.mapInstance) {
                window.mapInstance.remove(); // Remove the existing map instance
                window.mapInstance = null; // Clear the reference
            }

            // Create a new map instance
            window.mapInstance = L.map('map', {
                crs: L.CRS.Simple,
                minZoom: -1,
                maxZoom: 2,
            });

            const imageWidth = 700;
            const imageHeight = 500;
            const imageBounds = [[0, 0], [imageHeight, imageWidth]];
            const imageUrl = '{{ asset('images/reseau.png') }}';

            L.imageOverlay(imageUrl, imageBounds).addTo(window.mapInstance);
            window.mapInstance.fitBounds(imageBounds);

            const deviceIcons = {
                switch: L.icon({
                    iconUrl: '{{ asset('images/switch.png') }}',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                }),
                router: L.icon({
                    iconUrl: '{{ asset('images/router.png') }}',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                }),
                prise: L.icon({
                    iconUrl: '{{ asset('images/prise.png') }}',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                }),
            };

            const switchLayer = L.layerGroup().addTo(window.mapInstance);
            const routerLayer = L.layerGroup().addTo(window.mapInstance);
            const priseLayer = L.layerGroup().addTo(window.mapInstance);

            const overlayLayers = {
                "Switch": switchLayer,
                "Router": routerLayer,
                "Prise": priseLayer,
            };
            L.control.layers(null, overlayLayers).addTo(window.mapInstance);

            const devices = @json($devices);

            devices.forEach(device => {
                const { x, y, device_type } = device;

                const marker = L.marker([x, y], { icon: deviceIcons[device_type] });
                marker.bindPopup(`Device: ${device_type}<br>X: ${x}, Y: ${y}`);

                switch (device_type) {
                    case 'switch':
                        switchLayer.addLayer(marker);
                        break;
                    case 'router':
                        routerLayer.addLayer(marker);
                        break;
                    case 'prise':
                        priseLayer.addLayer(marker);
                        break;
                }
            });

            window.mapInstance.on('click', function (e) {
                const latLng = e.latlng;
                const x = latLng.lat.toFixed(2);
                const y = latLng.lng.toFixed(2);

                document.getElementById('x').value = x;
                document.getElementById('y').value = y;

                Livewire.dispatch('save-coordinates', { x: x, y: y });
            });

            Livewire.on('device-saved', (device) => {
                const { x, y, device_type } = device;

                const marker = L.marker([x, y], { icon: deviceIcons[device_type] });
                marker.bindPopup(`Device: ${device_type}<br>X: ${x}, Y: ${y}`);

                switch (device_type) {
                    case 'switch':
                        switchLayer.addLayer(marker);
                        break;
                    case 'router':
                        routerLayer.addLayer(marker);
                        break;
                    case 'prise':
                        priseLayer.addLayer(marker);
                        break;
                }
            });

            console.log('Map initialized');
        }

        // Attach the event listener only once
        if (!window.isListenerAttached) {
            document.addEventListener('initialize-map', () => {
                initializeMap();
            });
            window.isListenerAttached = true;
        }

    </script>

</div>
