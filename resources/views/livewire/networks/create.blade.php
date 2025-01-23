<div>
    <!-- Modal Content -->
    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" wire:model="image" id="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="button" @click="$dispatch('close-modal')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mr-2">
                Cancel
            </button>
            <x-button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Save Network
            </x-button>
        </div>
    </form>

</div>

