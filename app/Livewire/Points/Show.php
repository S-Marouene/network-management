<?php

namespace App\Livewire\Points;

use App\Models\devices;
use App\Models\Networks;
use App\Models\Points;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $points;
    public $networkId;
    public $network;

    public function mount($id)
    {
        $this->network = Networks::findOrFail($id);
        $this->points = Points::forNetwork($this->network->id)
            ->where('user_id', auth()->id())
            ->with('device')->get();
    }

    public function deletePoint($id)
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



    public function render()
    {
        return view('livewire.points.show', [
            'network' => $this->network,
            'points' => $this->points,
        ]);
    }
}
