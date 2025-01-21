<div >
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
    <div
        x-data="mapComponent()"
        x-init="initMap()"
    >
        <div id="map" style="width: 100%; height: 600px;"></div>
        <div class="form-container">
            <livewire:leaflet.create-device />
        </div>
    </div>
</div>

<script defer>
    function mapComponent() {
        return {
            map: null,
            deviceIcons: {},
            points: @json($points),
            initMap() {
                this.map = L.map('map', {
                    crs: L.CRS.Simple,
                    minZoom: -1,
                    maxZoom: 2
                });
                const imageWidth = 700;
                const imageHeight = 500;
                const imageBounds = [[0, 0], [imageHeight, imageWidth]];
                const imageUrl = '{{ asset('storage/reseau.png') }}';
                L.imageOverlay(imageUrl, imageBounds).addTo(this.map);
                this.map.fitBounds(imageBounds);


                const deviceSelect = document.getElementById('device_id');
                const overlayLayers = {};
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
                    this.points.forEach(point => {
                        const { x, y, device } = point;
                        if (x !== undefined && y !== undefined && device) {
                            if (!this.deviceIcons[device.icon]) {
                                this.deviceIcons[device.type] = L.icon({
                                    iconUrl: '{{ asset('storage/icons/') }}/' + device.icon,
                                    iconSize: [32, 32],
                                    iconAnchor: [16, 32],
                                });
                            }
                            const marker = L.marker([x, y], { icon: this.deviceIcons[device.type] });
                            const popupContent = `
                                    <b>Device Name:</b> ${device.name}<br>
                                    <b>Type:</b> ${device.type}<br>
                                    <b>Description:</b> ${device.description}<br>
                                    <b>Status:</b> ${device.status}<br>
                                    <b>IP Address:</b> ${device.ip_address}<br>
                                    <b>Model:</b> ${device.model}<br>
                                    <b>Serial Number:</b> ${device.serial_number}<br>
                                    <b>Coordinates:</b> X: ${x}, Y: ${y}<br>
                                    <b>icon:</b> ${device.icon}
                                `;
                            marker.bindPopup(popupContent);
                            const layerKey = `${device.name} (${device.type})`;
                            if (overlayLayers[layerKey]) {
                                overlayLayers[layerKey].addLayer(marker);
                            }

                        }
                    });
                }

                this.map.on('click', (e) => {
                    const latLng = e.latlng;
                    const x = latLng.lat.toFixed(2);
                    const y = latLng.lng.toFixed(2);
                    document.getElementById('x').value = x;
                    document.getElementById('y').value = y;
                    Livewire.dispatch('save-coordinates', { x: x, y: y });
                });

                Livewire.on('device-saved', (data) => {
                    const deviceData = data[0];
                    const {x, y, device} = deviceData;
                    if (x !== undefined && y !== undefined) {
                        if (!this.deviceIcons[device.icon]) {
                            this.deviceIcons[device.type] = L.icon({
                                iconUrl: '{{ asset('storage/icons/') }}/' + device.icon,
                                iconSize: [32, 32],
                                iconAnchor: [16, 32],
                            });
                        }
                        const marker = L.marker([x, y], { icon: this.deviceIcons[device.type] });
                        const popupContent = `
                                    <b>Device Name:</b> ${device.name}<br>
                                    <b>Type:</b> ${device.type}<br>
                                    <b>Description:</b> ${device.description}<br>
                                    <b>Status:</b> ${device.status}<br>
                                    <b>IP Address:</b> ${device.ip_address}<br>
                                    <b>Model:</b> ${device.model}<br>
                                    <b>Serial Number:</b> ${device.serial_number}<br>
                                    <b>Coordinates:</b> X: ${x}, Y: ${y}
                                `;
                        marker.bindPopup(popupContent);
                        const layerKey = `${device.name} (${device.type})`;
                        if (overlayLayers[layerKey]) {
                            overlayLayers[layerKey].addLayer(marker);
                        }
                    } else {
                        console.log("Coordinates are undefined!");
                    }
                });
            }
        };
    }
</script>
