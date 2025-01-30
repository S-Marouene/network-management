<?php

namespace App\Livewire\Points;

use App\Models\Device;
use App\Models\devices;
use App\Models\Networks;
use App\Models\Points;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $points;
    public $networkId;
    public $network;

    public function mount($id): void
    {
        $this->network = Networks::findOrFail($id);
        $this->points = Points::forNetwork($this->network->id)
            ->where('user_id', auth()->id())
            ->with('device')->get();
    }

    public function deletePoint($id): void
    {
        $d = Points::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if ($d) {
            $d->delete();
            $this->dispatch('device-deleted', [
                'id' => $id,
            ]);
            flash()->info('Device successfully deleted.');
        } else {
            session()->flash('error', 'Device not found or you do not have permission to delete it.');
        }
    }

    public function updateSize($pointId, $size): void
    {
        if (!in_array($size, [15, 22, 42])) {
            flash()->error('Invalid size selected.');
            return;
        }
        $point = Points::find($pointId);
        $device = Device::find($point->device_id);
        if ($point) {
            $point->size = $size;
            $point->save();
            flash()->success('Size updated successfully.');

            $this->dispatch('refresh-markers', [
                'x' => $point->x,
                'y' => $point->y,
                'device' => $device,
                'point' => $point,
            ]);



        } else {
            flash()->error('Point not found.');
        }
    }

    public function render()
    {
        return view('livewire.points.show', [
            'network' => $this->network,
            'points' => $this->points,
        ]);
    }
}
