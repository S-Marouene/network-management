<?php

namespace App\Livewire\Leaflet;
use App\Models\Points;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateDevice extends Component
{
    public $x;
    public $y;
    public $device_id;

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
            'device_id' => 'required|string',
        ]);
        Points::insert([
            'x' => $this->x,
            'y' => $this->y,
            'device_id' => $this->device_id,
        ]);

        $this->reset(['x', 'y', 'device_id']);
        $this->dispatch('device-saved');
    }



    public function render()
    {
        return view('livewire.leaflet.create-device');
    }
}
