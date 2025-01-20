<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Devices List</h1>

    @if (session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach ($devices as $device)
                <tr>
                    <!-- Icon -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ $device->icon ? asset('storage/icons/' . $device->icon) : asset('images/placeholder.png') }}"
                             alt="{{ $device->name }}" class="h-16 w-16 rounded-md">
                    </td>
                    <!-- Name -->
                    <td class="px-6 py-4 whitespace-nowrap">{{ $device->name }}</td>
                    <!-- Type -->
                    <td class="px-6 py-4 whitespace-nowrap">{{ $device->type }}</td>
                    <!-- Description -->
                    <td class="px-6 py-4 whitespace-nowrap">{{ $device->description }}</td>
                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $device->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $device->status }}
                            </span>
                    </td>
                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- Edit Button -->
                        <a href="{{ route('devices.edit', $device->id) }}" class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <button wire:click="deleteDevice({{ $device->id }})" class="text-red-600 hover:text-red-900 ml-4">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
