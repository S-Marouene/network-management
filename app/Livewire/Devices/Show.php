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
        $devices = Device::all();
        return view('livewire.devices.show', ['devices' => $devices]);
    }


    public function deleteDevice($id)
    {
        Device::find($id)->delete();
        session()->flash('message', 'Device deleted successfully.');
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
        $this->devices = Device::all();
    }
}
