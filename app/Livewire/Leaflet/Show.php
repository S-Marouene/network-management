<?php

namespace App\Livewire\Leaflet;

use App\Models\devices;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $devices;

    public function mount()
    {
        $this->dispatch('initialize-map');

        // Fetch all devices from the database
        $this->devices = devices::all();
    }

    public function render()
    {

        return view('livewire.leaflet.show', [
            'devices' => $this->devices,
        ]);

    }
}
