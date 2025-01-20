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
</div>

<script>
    $(document).ready(function () {
        const map = L.map('map', {
            crs: L.CRS.Simple,
            minZoom: -1,
            maxZoom: 2
        });
        const imageWidth = 700;
        const imageHeight = 500;
        const imageBounds = [[0, 0], [imageHeight, imageWidth]];
        const imageUrl = '{{ asset('images/reseau.png') }}';
        L.imageOverlay(imageUrl, imageBounds).addTo(map);
        map.fitBounds(imageBounds);

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
                iconUrl: '{{ asset('images/prise.png') }}', // Path to prise icon
                iconSize: [32, 32],
                iconAnchor: [16, 32],
            }),
        };

        const switchLayer = L.layerGroup().addTo(map);
        const routerLayer = L.layerGroup().addTo(map);
        const priseLayer = L.layerGroup().addTo(map);
        const overlayLayers = {
            "Switch": switchLayer,
            "Router": routerLayer,
            "Prise": priseLayer,
        };
        L.control.layers(null, overlayLayers).addTo(map);
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

        map.on('click', function (e) {
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
    });
</script>
