<div>
    <style>
        #map {
            width: 100%;
            height: 600px;
            padding: 0;
            margin: 0;
            position: relative; /* Ensure the map container is positioned relative */
        }
        .spinner {
            width: 3em;
            height: 3em;
            cursor: not-allowed;
            border-radius: 50%;
            border: 2px solid #444;
            box-shadow: -10px -10px 10px #6359f8, 0px -10px 10px 0px #9c32e2, 10px -10px 10px #f36896, 10px 0 10px #ff0b0b, 10px 10px 10px 0px#ff5500, 0 10px 10px 0px #ff9500, -10px 10px 10px 0px #ffb700;
            animation: rot55 0.7s linear infinite;
            z-index: 10000;
            position: absolute;
            top: 50%;
            left: 50%;
        }
        @keyframes rot55 {
            to {
                transform: rotate(360deg);
            }
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
            z-index: 9999; /* Ensure it's above the map but below the spinner */
            display: none; /* Hidden by default */
        }
        .overlay.active {
            display: block;
        }
    </style>
    <div>
        <div class="container mx-auto p-4" wire:ignore>
            <h1 class="text-xl font-bold">{{ $network->name }}</h1>
            <p>{{ $network->description }}</p>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <div x-data="mapComponent()" x-init="initMap()" class="lg:col-span-4">
                    <div id="map" style="width: 100%; height: 600px;">
                        <div x-data="{ showSpinner: false }"
                             x-effect="if (Alpine.store('marker').positionUpdated) {
                                showSpinner = false;
                                Alpine.store('marker').positionUpdated = false;}"
                             @drag-end.window="showSpinner = true;">
                            <div x-show="showSpinner" class="spinner"></div>
                            <div x-show="showSpinner" class="overlay active"></div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <livewire:points.create-point :networkId="$network->id" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('marker', {
            positionUpdated: false,
        });
    });

    function GeneratePopup(device, point, x, y) {
        const size = point.size.toString();
        return `
        <b>Device Name:</b> ${device.name}<br>
        <b>Type:</b> ${device.type}<br>
        <b>Description:</b> ${device.description}<br>
        <b>Status:</b> ${device.status}<br>
        <b>IP Address:</b> ${device.ip_address}<br>
        <b>Model:</b> ${device.model}<br>
        <b>Serial Number:</b> ${point.size}<br>
        <b>Coordinates:</b> X: ${x}, Y: ${y}<br><br>
        <div>
            <label>
                <input type="radio" name="size" value="15" ${size === '15' ? 'checked' : ''} wire:click="updateSize(${point.id}, 15)"> Small
            </label>
            <label>
                <input type="radio" name="size" value="22" ${size === '22' ? 'checked' : ''} wire:click="updateSize(${point.id}, 22)"> Big
            </label>
            <label>
                <input type="radio" name="size" value="42" ${size === '42' ? 'checked' : ''} wire:click="updateSize(${point.id}, 42)"> Very Big
            </label>
        </div><br>
        <button wire:click="deletePoint(${point.id})" style="margin-top: 10px; padding: 5px 10px; background: red; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Delete
        </button>
    `;
    }

    function mapComponent() {
        return {
            map: null,
            deviceIcons: {},
            points: @json($points),
            initMap() {
                this.map = L.map('map', {
                    crs: L.CRS.Simple,
                    minZoom: 0,
                    maxZoom: 3,
                    fullscreenControl: true,
                    zoomAnimation:false
                });

                const imageUrl = '{{ asset('storage/networks/' . $network->image) }}';
                const img = new Image();
                const overlayLayers = {};
                img.src = imageUrl;


                img.onload = () => {
                    const imageWidth = img.naturalWidth;
                    const imageHeight = img.naturalHeight;
                    const imageBounds = [[0, 0], [imageHeight, imageWidth]];
                    L.imageOverlay(imageUrl, imageBounds).addTo(this.map);
                    this.map.fitBounds(imageBounds);
                    const deviceSelect = document.getElementById('device_id');
                    Array.from(deviceSelect.options).forEach(option => {
                        if (option.value) {
                            const match = option.text.match(/^(.*) \((.*)\)$/);
                            if (match) {
                                const name = match[1]; // Device name
                                const type = match[2]; // Device type
                                const layerKey = `${name} (${type})`; // Combine name and type for the layer key
                                overlayLayers[layerKey] = L.layerGroup().addTo(this.map);
                            }
                        }
                    });
                    L.control.layers(null, overlayLayers).addTo(this.map);
                    if (this.points && this.points.length > 0) {
                        this.markers = {};
                        this.points.forEach(point => {
                            const { x, y, device } = point;
                            if (x !== undefined && y !== undefined && device) {
                                if (!this.deviceIcons[device.icon]) {
                                    this.deviceIcons[device.type] = L.icon({
                                        iconUrl: '{{ asset('storage/icons/') }}/' + device.icon,
                                        iconSize: [point.size, point.size],
                                        iconAnchor: [16, 32],
                                    });
                                }
                                const marker = L.marker([x, y], { icon: this.deviceIcons[device.type],draggable: 'true' });
                                const popupContent = GeneratePopup(device, point, x, y);
                                marker.bindPopup(popupContent);
                                const layerKey = `${device.name} (${device.type})`;
                                if (overlayLayers[layerKey]) {
                                    overlayLayers[layerKey].addLayer(marker);
                                }
                                marker.on('dragend', (event) => {
                                    const newLatLng = event.target.getLatLng();
                                    const newX = newLatLng.lat.toFixed(2);
                                    const newY = newLatLng.lng.toFixed(2);
                                    Livewire.dispatch('update-marker-position', {
                                        pointId: point.id,
                                        x: newX,
                                        y: newY
                                    });
                                    window.dispatchEvent(new CustomEvent('drag-end'));
                                });
                                this.markers[point.id] = marker;
                            }
                        });
                    }
                };

                Livewire.on('device-saved', (data) => {
                    const deviceData = data[0];
                    const { x, y, device,point } = deviceData;
                    if (x !== undefined && y !== undefined) {
                        if (!this.deviceIcons[device.icon]) {
                            this.deviceIcons[device.type] = L.icon({
                                iconUrl: '{{ asset('storage/icons/') }}/' + device.icon,
                                iconSize: [point.size, point.size],
                                iconAnchor: [16, 32],
                            });
                        }
                        const marker = L.marker([x, y], { icon: this.deviceIcons[device.type],draggable: 'true' });
                        marker.on('dragend', (event) => {
                            const newLatLng = event.target.getLatLng();
                            const newX = newLatLng.lat.toFixed(2);
                            const newY = newLatLng.lng.toFixed(2);
                            Livewire.dispatch('update-marker-position', {
                                pointId: point.id,
                                x: newX,
                                y: newY
                            });
                            window.dispatchEvent(new CustomEvent('drag-end'));
                        });
                        this.markers[point.id] = marker;
                        const popupContent = GeneratePopup(device, point, x, y);
                        marker.bindPopup(popupContent);

                        const layerKey = `${device.name} (${device.type})`;
                        if (overlayLayers[layerKey]) {
                            overlayLayers[layerKey].addLayer(marker);
                        }
                    } else {
                        console.log("Coordinates are undefined!");
                    }
                });

                Livewire.on('device-deleted', (data) => {
                    const pointId = data[0].id;
                    if (this.markers[pointId]) {
                        this.map.removeLayer(this.markers[pointId]);
                        delete this.markers[pointId];
                    }
                });

                Livewire.on('refresh-markers', (data) => {
                    const { x, y, device, point } = data[0];
                    if (this.markers[point.id]) {
                        var icon = this.markers[point.id].options.icon;
                        icon.options.iconSize = [point.size, point.size];
                        this.markers[point.id].setIcon(icon);
                        const popupContent = GeneratePopup(device, point, x, y);
                        this.markers[point.id].bindPopup(popupContent);
                        $(".leaflet-popup-close-button")[0].click();
                    }
                });

                this.map.on('click', (e) => {
                    const latLng = e.latlng;
                    const x = latLng.lat.toFixed(2);
                    const y = latLng.lng.toFixed(2);
                    document.getElementById('x').value = x;
                    document.getElementById('y').value = y;
                    Livewire.dispatch('save-coordinates', { x: x, y: y });
                });
            }
        };
    }

</script>
@script
    <script>
        $wire.on('marker-Position-Updated', () => {
            Alpine.store('marker').positionUpdated = true;
        });
    </script>
@endscript
