<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;

class LogoManager extends Component
{
    use WithFileUploads;

    public $logo;
    
    public function mount()
    {
        if (auth()->user()->role !== 'Manager') {
            abort(403, 'Only managers can manage company logo.');
        }
    }

    public function saveLogo()
    {
        if (auth()->user()->role !== 'Manager') {
            session()->flash('error', 'Only managers can perform this action.');
            return;
        }
        
        $this->validate([
            'logo' => 'required|image|max:1024',
        ]);

        $imageData = base64_encode(file_get_contents($this->logo->getRealPath()));
        $imageType = $this->logo->getMimeType();

        SiteSetting::updateOrCreate(
            ['key' => 'company_logo'],
            ['value' => json_encode([
                'data' => $imageData,
                'type' => $imageType
            ])]
        );

        session()->flash('message', 'Logo updated successfully.');
    }

    public function render()
    {
        $logoSetting = SiteSetting::where('key', 'company_logo')->first();
        $logoData = $logoSetting ? json_decode($logoSetting->value, true) : null;
        
        return view('livewire.logo-manager', [
            'currentLogo' => $logoData ? 'data:' . $logoData['type'] . ';base64,' . $logoData['data'] : null
        ]);
    }
}