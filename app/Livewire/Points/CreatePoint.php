<?php

namespace App\Livewire\Points;
use App\Models\Device;
use App\Models\Points;
use Livewire\Attributes\On;
use Livewire\Component;

class CreatePoint extends Component
{
    public $x;
    public $y;
    public $device_id;
    public $network_id;
    public $devices;

    public function mount($networkId)
    {
        $this->network_id = $networkId;
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
            'network_id' => 'required|exists:networks,id',
        ]);
            $point = Points::insert([
                'x' => $this->x,
                'y' => $this->y,
                'device_id' => $this->device_id,
                'network_id' => $this->network_id,
            ]);

            $device = Device::find($this->device_id);

            $this->dispatch('device-saved', [
                'x' => $this->x,
                'y' => $this->y,
                'device' => $device,
            ]);
            $this->reset(['x', 'y', 'device_id']);
            flash()->success('Device saved successfully.');


    }



    public function render()
    {
        return view('livewire.points.create-point');
    }
}
