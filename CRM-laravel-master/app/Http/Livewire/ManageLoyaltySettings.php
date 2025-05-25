<?php

namespace App\Http\Livewire;

use App\Models\LoyaltySetting;
use Livewire\Component;

class ManageLoyaltySettings extends Component
{
    public $settings;
    public $editMode = false;
    
    protected $rules = [
        'settings.points_per_appointment' => 'required|integer|min:1',
        'settings.points_required' => 'required|integer|min:1',
        'settings.discount_percentage' => 'required|numeric|min:0|max:100',
        'settings.minimum_spend' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->settings = LoyaltySetting::first() ?? new LoyaltySetting();
    }

    public function toggleEdit()
    {
        $this->editMode = !$this->editMode;
    }

    public function saveSettings()
    {
        $this->validate();
        $this->settings->save();
        $this->editMode = false;
        session()->flash('message', 'Loyalty settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.manage-loyalty-settings');
    }
}