<?php
namespace App\Livewire\Devices;

use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;

    public $device;
    public $name;
    public $icon;
    public $newIcon;
    public $type;
    public $description;
    public $status;
    public $ip_address;
    public $model;
    public $serial_number;
    #[Layout('layouts.app')]
    public function mount($id)
    {
        $this->device = Device::findOrFail($id);
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
        $this->validate([
            'name' => 'required|string|max:255',
            'newIcon' => 'nullable|image|max:2048',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'ip_address' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
        ]);

        if ($this->newIcon) {
            if ($this->device->icon && \Storage::exists('public/icons/' . $this->device->icon)) {
                \Storage::delete('public/icons/' . $this->device->icon);
            }
            $iconName = time() . '.' . $this->newIcon->getClientOriginalExtension();
            $this->newIcon->storeAs('public/icons', $iconName);
            $this->device->icon = $iconName;
        }

        $this->device->update([
            'name' => $this->name,
            'icon' => $this->device->icon ?? $this->device->icon,
            'type' => $this->type,
            'description' => $this->description,
            'status' => $this->status,
            'ip_address' => $this->ip_address,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
        ]);

        session()->flash('message', 'Device updated successfully.');
    }

    public function render()
    {
        return view('livewire.devices.edit');
    }
}
