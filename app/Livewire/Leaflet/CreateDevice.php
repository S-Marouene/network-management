<?php

namespace App\Livewire\Leaflet;

use App\Models\devices;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateDevice extends Component
{
    public $x;
    public $y;
    public $device_type;

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
            'device_type' => 'required|string',
        ]);
        devices::insert([
            'x' => $this->x,
            'y' => $this->y,
            'device_type' => $this->device_type,
        ]);

        $this->reset(['x', 'y', 'device_type']);
        $this->dispatch('device-saved');
    }



    public function render()
    {
        return view('livewire.leaflet.create-device');
    }
}
