<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Livewire\Component;

class ManageLocations extends Component
{

    private $locations;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $location;

    public $confirmingLocationAdd;


    public $confirmingLocationDeletion = false;

    protected $rules = [
        "location.name" => "required|string|max:255",
        "location.address" => "required|string|max:255",
        "location.telephone_number" => "required|string|min_digits:10|max_digits:10",
        "location.status" => "required|boolean",
    ];
    public function render()
    {
        $this->locations = Location::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })->paginate(10);

        return view('livewire.manage-locations', [
            'locations' => $this->locations,
        ]);
    }

    public function confirmLocationEdit(Location $location) {
        $this->location = $location;
        $this->confirmingLocationAdd= true;
    }
    public function confirmLocationDeletion($locationId) {
        $this->confirmingLocationDeletion = $locationId;
    }

    public function saveLocation() {
        $this->validate();

        if (isset($this->location->id)) {
            $this->location->save();
        } else {
            Location::create(
                [
                    'name' => $this->location['name'],
                    'address' => $this->location['address'],
                    'telephone_number' => $this->location['telephone_number'],
                    'status' => $this->location['status'],
                ]
            );
        }
        
        $this->location = null;
        $this->closeModal();
        session()->flash('message', 'Location saved successfully.');
    }

    public function deleteLocation($locationId) {
        try {
            $location = Location::find($locationId);
            if ($location) {
                // Check if location has any related cart services
                if ($location->cartServices()->exists()) {
                    session()->flash('error', 'Cannot delete location because it has related appointments or services.');
                } else {
                    $location->delete();
                    session()->flash('message', 'Location deleted successfully.');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete location. It may have related records.');
        }
        
        $this->confirmingLocationDeletion = false;
    }

    public function confirmLocationAdd() {
        $this->confirmingLocationAdd = true;
    }

    public function closeModal()
    {
        $this->confirmingLocationAdd = false;
        $this->resetValidation();
        $this->location = null;
    }

}
