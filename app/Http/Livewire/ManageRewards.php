<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ManageRewards extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $reward;
    public $rewardId;
    public $name;
    public $description;
    public $points_required;
    public $image;
    public $active_from;
    public $expiry_date;
    public $is_active = true;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'points_required' => 'required|integer|min:1',
        'image' => 'nullable|image|max:1024',
        'active_from' => 'nullable|date',
        'expiry_date' => 'nullable|date|after:active_from',
        'is_active' => 'boolean'
    ];

    public function render()
    {
        $rewards = Reward::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.manage-rewards', [
            'rewards' => $rewards
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'description', 'points_required', 'image', 'active_from', 'expiry_date']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit(Reward $reward)
    {
        $this->resetValidation();
        $this->reward = $reward;
        $this->rewardId = $reward->id;
        $this->name = $reward->name;
        $this->description = $reward->description;
        $this->points_required = $reward->points_required;
        $this->active_from = $reward->active_from;
        $this->expiry_date = $reward->expiry_date;
        $this->is_active = $reward->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'points_required' => $this->points_required,
            'active_from' => $this->active_from,
            'expiry_date' => $this->expiry_date,
            'is_active' => $this->is_active
        ];

        if ($this->image) {
            $imagePath = $this->image->store('rewards', 'public');
            $data['image_path'] = $imagePath;

            if ($this->editMode && $this->reward->image_path) {
                Storage::disk('public')->delete($this->reward->image_path);
            }
        }

        if ($this->editMode) {
            $this->reward->update($data);
            session()->flash('message', 'Reward updated successfully.');
        } else {
            Reward::create($data);
            session()->flash('message', 'Reward created successfully.');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'points_required', 'image', 'active_from', 'expiry_date']);
    }

    public function delete(Reward $reward)
    {
        if ($reward->image_path) {
            Storage::disk('public')->delete($reward->image_path);
        }
        $reward->delete();
        session()->flash('message', 'Reward deleted successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['name', 'description', 'points_required', 'image', 'active_from', 'expiry_date']);
    }
}