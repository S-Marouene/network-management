<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.app')]
    public $showModal = false;
    protected $listeners = ['device-created' => 'refreshDevices'];

    public function render()
    {
        $userId = auth()->id();
        $devices = Device::where('user_id', $userId)->get();
        return view('livewire.devices.show', ['devices' => $devices]);
    }


    public function deleteDevice($id)
    {
        $device = Device::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
            if ($device) {
                $device->delete();
                flash()->info('Device deleted successfully.');
            } else {
                session()->flash('error', 'Device not found or you do not have permission to delete it.');
            }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function refreshDevices()
    {
        $this->devices = Device::where('user_id', auth()->id())->get();
    }
}
