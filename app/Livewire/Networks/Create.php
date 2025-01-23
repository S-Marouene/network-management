<?php

namespace App\Livewire\Networks;

use App\Models\Device;
use App\Models\Networks;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $image;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048', // Allow image upload (max 2MB)
        'description' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();
        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('public/networks', $imageName);
        }
        Networks::create([
            'name' => $this->name,
            'image' => $imageName ?? null,
            'description' => $this->description,
            'user_id' => auth()->id(),
        ]);
        $this->reset();
        $this->dispatch('network-created');
        $this->dispatch('close-modal');

        flash()->success('User saved successfully!');

    }

    public function render()
    {
        return view('livewire.networks.create');
    }
}
