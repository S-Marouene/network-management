<?php
namespace App\Livewire\Devices;

use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{

    use WithFileUploads; // Enable file uploads

    public $device; // The device being edited
    public $name;
    public $icon;
    public $newIcon; // For handling file uploads
    public $type;
    public $description;
    public $status;
    public $ip_address;
    public $model;
    public $serial_number;
    #[Layout('layouts.app')]
    // Mount the component with the device data
    public function mount($id)
    {
        $this->device = Device::findOrFail($id); // Find the device by ID
        $this->name = $this->device->name;
        $this->icon = $this->device->icon;
        $this->type = $this->device->type;
        $this->description = $this->device->description;
        $this->status = $this->device->status;
        $this->ip_address = $this->device->ip_address;
        $this->model = $this->device->model;
        $this->serial_number = $this->device->serial_number;
    }

    public function update()
    {
        // Validate the input data
        $this->validate([
            'name' => 'required|string|max:255',
            'newIcon' => 'nullable|image|max:2048', // Allow image upload (max 2MB)
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'ip_address' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
        ]);

        // Handle the icon upload
        if ($this->newIcon) {
            // Delete the old icon if it exists
            if ($this->device->icon && \Storage::exists('public/icons/' . $this->device->icon)) {
                \Storage::delete('public/icons/' . $this->device->icon);
            }

            // Store the new icon
            $iconName = time() . '.' . $this->newIcon->getClientOriginalExtension();
            if ($this->newIcon->storeAs('public/icons', $iconName)) {
                \Log::info('File uploaded successfully.', ['file' => $iconName]);
            } else {
                \Log::error('File upload failed.', ['file' => $iconName]);
            }

            // Update the device's icon property
            $this->device->icon = $iconName;
        }

        // Update the device with other fields
        $this->device->update([
            'name' => $this->name,
            'icon' => $this->device->icon ?? $this->device->icon, // Use the new icon or keep the old one
            'type' => $this->type,
            'description' => $this->description,
            'status' => $this->status,
            'ip_address' => $this->ip_address,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
        ]);

        // Show a success message
        session()->flash('message', 'Device updated successfully.');
    }

    public function render()
    {
        return view('livewire.devices.edit');
    }
}
