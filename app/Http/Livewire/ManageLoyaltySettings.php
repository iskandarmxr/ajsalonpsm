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
        'settings.loyalty_rules' => 'required|array',
        'settings.loyalty_rules.*' => 'required|string'
    ];

    public function mount()
    {
        $this->settings = LoyaltySetting::first() ?? new LoyaltySetting();
        if (empty($this->settings->loyalty_rules)) {
            $this->settings->loyalty_rules = [
                'You receive 100 points with your first purchase.',
                'Points expire after 11 months.',
                'For each 5 USD spent, you receive 250 points.',
                'Each purchase earns a minimum of 1 points and a maximum of 10,000 points.'
            ];
        }
    }

    public function toggleEdit()
    {
        $this->editMode = !$this->editMode;
    }

    public function addRule()
    {
        $rules = $this->settings->loyalty_rules ?? [];
        $rules[] = '';
        $this->settings->loyalty_rules = $rules;
    }

    public function removeRule($index)
    {
        $rules = $this->settings->loyalty_rules;
        unset($rules[$index]);
        $this->settings->loyalty_rules = array_values($rules);
        $this->settings->save();
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