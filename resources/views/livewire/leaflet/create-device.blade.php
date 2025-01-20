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
                <label for="device_type">Device Type:</label>
                <select id="device_type" wire:model="device_type">
                    <option value="">Select Device</option>
                    <option value="switch">Switch</option>
                    <option value="router">Router</option>
                    <option value="prise">Prise</option>
                </select>
            </div>
            <button class="btn btn-success" wire:click="saveDevice">Save Device</button>
        </div>
    </div>
</div>
