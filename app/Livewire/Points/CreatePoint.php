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
    public $size;

    public function mount($networkId): void
    {
        $this->network_id = $networkId;
        $this->devices = Device::where('user_id', auth()->id())->get();
        $this->size = "15";
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
            'size' => 'required',
        ]);
            $point = Points::create([
                'x' => $this->x,
                'y' => $this->y,
                'device_id' => $this->device_id,
                'network_id' => $this->network_id,
                'user_id' => auth()->id(),
                'size' => $this->size, // Add this line
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $device = Device::find($this->device_id);
            $this->dispatch('device-saved', [
                'x' => $this->x,
                'y' => $this->y,
                'device' => $device,
                'point' => $point,
            ]);
            $this->reset(['x', 'y', 'device_id']);
            flash()->success('Device saved successfully.');
    }

    #[On('update-marker-position')]
    public function updateMarkerPosition($pointId, $x, $y): void
    {
        $point = Points::find($pointId);
        if ($point) {
            $point->update([
                'x' => $x,
                'y' => $y,
            ]);
        }
        flash()->success('Device moved ! new position saved  successfully.');
        $this->dispatch('marker-Position-Updated');
    }





    public function render()
    {
        return view('livewire.points.create-point');
    }
}
