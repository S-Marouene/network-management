<?php

namespace App\Livewire\Leaflet;

use App\Models\devices;
use App\Models\Points;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $points;
    public function mount()
    {
        $this->points = Points::with('device')->get();
    }

    public function render()
    {
        return view('livewire.leaflet.show', [
            'points' => $this->points,
        ]);

    }
}
