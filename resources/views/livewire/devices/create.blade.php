<div>
    <!-- Modal Content -->
    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
            <input type="file" wire:model="icon" id="icon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <input type="text" wire:model="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="ip_address" class="block text-sm font-medium text-gray-700">IP Address</label>
            <input type="text" wire:model="ip_address" id="ip_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('ip_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
            <input type="text" wire:model="model" id="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
            <input type="text" wire:model="serial_number" id="serial_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('serial_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>


        <div class="flex justify-end">
            <button type="button" @click="$dispatch('close-modal')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mr-2">
                Cancel
            </button>
            <x-button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Save Device
            </x-button>
        </div>
    </form>
</div>
