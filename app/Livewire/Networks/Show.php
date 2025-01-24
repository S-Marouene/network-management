<?php

namespace App\Livewire\Networks;

use App\Models\Device;
use App\Models\Networks;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.app')]
    public $networks;

    public $showModal = false;

    public function mount()
    {
        $this->networks = Networks::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.networks.show');
    }

    public function deleteNetwork($id)
    {
        $d = Networks::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
        if ($d) {
            $d->delete();
            $this->dispatch('network-deleted');
            flash()->info('Network successfully deleted.');
        } else {
            session()->flash('error', 'Device not found or you do not have permission to delete it.');
        }

    }

    protected $listeners = [
        'network-created' => 'refreshNetworks',
        'network-deleted' => 'refreshNetworks',
    ];

    public function refreshNetworks()
    {
        $this->networks = Networks::where('user_id', auth()->id())->get();
    }
    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
