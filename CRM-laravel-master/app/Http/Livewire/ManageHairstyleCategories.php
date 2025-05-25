<?php

namespace App\Http\Livewire;

use App\Models\HairstyleCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ManageHairstyleCategories extends Component
{
    use WithPagination;

    public $search;
    public $category;
    public $confirmingCategoryAdd = false;
    public $confirmingCategoryDeletion = false;
    public $isEditing = false;

    protected $rules = [
        'category.name' => 'required|string|max:255',
        'category.description' => 'nullable|string'
    ];

    public function render()
    {
        $categories = HairstyleCategory::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })->paginate(10);

        return view('livewire.manage-hairstyle-categories', [
            'categories' => $categories
        ]);
    }

    public function confirmCategoryAdd()
    {
        $this->category = [];
        $this->isEditing = false;
        $this->confirmingCategoryAdd = true;
    }

    public function confirmCategoryEdit(HairstyleCategory $category)
    {
        $this->category = $category;
        $this->isEditing = true;
        $this->confirmingCategoryAdd = true;
    }

    public function saveCategory()
    {
        $this->validate();
    
        if (isset($this->category->id)) {
            $this->category->save();
        } else {
            HairstyleCategory::create([
                'name' => $this->category['name'],
                'description' => $this->category['description'] ?? null,
            ]);
        }
    
        $this->confirmingCategoryAdd = false;
        $this->category = null;
        session()->flash('message', 'Hairstyle category saved successfully.');
        $this->emit('hairstyleCategoryChanged'); // Add this line
    }

    public function deleteCategory(HairstyleCategory $category)
    {
        $category->delete();
        $this->confirmingCategoryDeletion = false;
        session()->flash('message', 'Hairstyle category deleted successfully.');
        $this->emit('hairstyleCategoryChanged'); // Add this line
    }
}