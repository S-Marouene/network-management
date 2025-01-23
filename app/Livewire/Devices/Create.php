<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $icon;
    public $type;
    public $description;
    public $status = 'active'; // Default status
    public $ip_address;
    public $model;
    public $serial_number;

    protected $rules = [
        'name' => 'required|string|max:255',
        'icon' => 'nullable|image|max:2048',
        'type' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string|in:active,inactive',
        'ip_address' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'serial_number' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        // Handle file upload
        if ($this->icon) {
            $iconName = time() . '.' . $this->icon->getClientOriginalExtension();
            $this->icon->storeAs('public/icons', $iconName);
        }

        // Create the device
        Device::create([
            'name' => $this->name,
            'icon' => $iconName ?? null,
            'type' => $this->type,
            'description' => $this->description,
            'status' => $this->status,
            'ip_address' => $this->ip_address,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'user_id' => auth()->id(),
        ]);

        // Reset the form
        $this->reset();

        $this->dispatch('device-created');

        // Close the modal
        $this->dispatch('close-modal');
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.devices.create');
    }
}
