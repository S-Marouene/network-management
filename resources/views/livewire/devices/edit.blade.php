<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Device</h1>

    <!-- Form to edit the device -->
    <form wire:submit.prevent="update">
        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Icon -->
        <div class="mb-4">
            <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>

            <!-- Display the current icon or the temporary new icon -->
            @if ($newIcon)
                <div class="mt-2">
                    <img src="{{ $newIcon->temporaryUrl() }}" alt="New Icon" class="h-16 w-16 rounded-md">
                </div>
            @elseif ($icon)
                <div class="mt-2">
                    <img src="{{ asset('storage/icons/' . $icon) }}" alt="Current Icon" class="h-16 w-16 rounded-md">
                </div>
            @endif

            <!-- File input for new icon -->
            <input type="file" wire:model="newIcon" id="icon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('newIcon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Type -->
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <input type="text" wire:model="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- IP Address -->
        <div class="mb-4">
            <label for="ip_address" class="block text-sm font-medium text-gray-700">IP Address</label>
            <input type="text" wire:model="ip_address" id="ip_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('ip_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Model -->
        <div class="mb-4">
            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
            <input type="text" wire:model="model" id="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Serial Number -->
        <div class="mb-4">
            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
            <input type="text" wire:model="serial_number" id="serial_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('serial_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <x-button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md border border-red-500">
            Update Device
        </x-button>
    </form>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>
