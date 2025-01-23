<?php

namespace App\Livewire\Networks;

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
        $this->networks = Networks::all();
    }

    public function render()
    {
        return view('livewire.networks.show');
    }

    public function deleteNetwork($id)
    {
        Networks::find($id)->delete();
        $this->dispatch('network-deleted');
        flash()->info('Network successfully deleted.');
    }

    protected $listeners = [
        'network-created' => 'refreshNetworks',
        'network-deleted' => 'refreshNetworks',
    ];

    public function refreshNetworks()
    {
        $this->networks = Networks::all();
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
