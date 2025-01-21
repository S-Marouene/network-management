<div>
    <div>
        <h1>Create Device </h1>
        <div class="form-container">
            <div>
                <label for="x">X Coordinate:</label>
                <input type="text" id="x" wire:model="x" readonly>
            </div>
            <div>
                <label for="y">Y Coordinate:</label>
                <input type="text" id="y" wire:model="y" readonly>
            </div>
            <div>
                <label for="device_id">Device:</label>
                <select id="device_id" wire:model="device_id">
                    <option value="">Select Device</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->type }})</option>
                    @endforeach
                </select>
            </div>
            <x-button class="btn btn-success" wire:click="saveDevice">Save Device</x-button>
        </div>
    </div>
</div>
