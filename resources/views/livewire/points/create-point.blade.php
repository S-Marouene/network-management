<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
    <h1 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Create Device</h1>
    <div class="space-y-3">
        <div>
            <label for="x" class="block text-sm font-medium text-gray-700 dark:text-gray-300">X Coordinate:</label>
            <input
                type="text"
                id="x"
                wire:model="x"
                readonly
                class="mt-1 block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            />
        </div>
        <div>
            <label for="y" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Y Coordinate:</label>
            <input
                type="text"
                id="y"
                wire:model="y"
                readonly
                class="mt-1 block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            />
        </div>
        <div>
            <label for="device_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Device:</label>
            <select
                id="device_id"
                wire:model="device_id"
                class="mt-1 block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            >
                <option value="">Select Device</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->type }})</option>
                @endforeach
            </select>
        </div>

        <!-- Add Radio Buttons for Device Size -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Device Size:</label>
            <div class="mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="size" value="15" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" checked>
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Small</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="size" value="22" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Big</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="size" value="42" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Very Big</span>
                </label>
            </div>
        </div>

        <div class="mt-4">
            <button
                wire:click="saveDevice"
                class="w-full flex justify-center py-1 px-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Save Device
            </button>
        </div>
    </div>
</div>
