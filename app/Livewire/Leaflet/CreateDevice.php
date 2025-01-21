<?php

namespace App\Livewire\Leaflet;
use App\Models\Device;
use App\Models\Points;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateDevice extends Component
{
    public $x;
    public $y;
    public $device_id;
    public $devices;

    public function mount()
    {
        $this->devices = Device::all();
    }

    #[On('save-coordinates')]
    public function setCoordinates($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function saveDevice(): void
    {
        $this->validate([
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'device_id' => 'required|exists:devices,id',
        ]);
            $point = Points::insert([
                'x' => $this->x,
                'y' => $this->y,
                'device_id' => $this->device_id,
            ]);

            $device = Device::find($this->device_id);

            $this->dispatch('device-saved', [
                'x' => $this->x,
                'y' => $this->y,
                'device' => $device, // Pass the device type
            ]);
            $this->reset(['x', 'y', 'device_id']);


    }



    public function render()
    {
        return view('livewire.leaflet.create-device');
    }
}
