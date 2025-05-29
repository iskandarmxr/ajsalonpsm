<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Hairstyle;
use App\Models\HairstyleCategory;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageHairstyles extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Add this event listener at the top of the class
    protected $listeners = ['hairstyleCategoryChanged' => '$refresh'];
    public $name;
    public $description;
    public $category_id;
    public $image;
    public $search = '';
    public $showModal = false;
    public $editingHairstyle = null;
    public $isEditing = false;


    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'description' => 'required',
            'category_id' => 'required|exists:hairstyle_categories,id',
            'image' => $this->isEditing ? 'nullable|image|max:1024' : 'required|image|max:1024',
        ];
    }

    public function render()
    {
        $hairstyles = Hairstyle::where('name', 'like', '%'.$this->search.'%')
            ->orWhereHas('category', function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);
            
        $categories = HairstyleCategory::all();

        return view('livewire.manage-hairstyles', [
            'hairstyles' => $hairstyles,
            'categories' => $categories
        ]);
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id,
            ];
            
            if ($this->image) {
                $imagePath = $this->image->store('hairstyles', 'public');
                $data['image'] = $imagePath;
            }
            
            $this->editingHairstyle->update($data);
            session()->flash('message', 'Hairstyle updated successfully.');
        } else {
            $imagePath = $this->image->store('hairstyles', 'public');
            
            Hairstyle::create([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'image' => $imagePath,
            ]);
            session()->flash('message', 'Hairstyle created successfully.');
        }
    
        $this->reset(['name', 'description', 'category_id', 'image', 'showModal', 'isEditing', 'editingHairstyle']);
    }

    public function edit($id)
    {
        $this->editingHairstyle = Hairstyle::find($id);
        $this->name = $this->editingHairstyle->name;
        $this->description = $this->editingHairstyle->description;
        $this->category_id = $this->editingHairstyle->category_id;
        $this->isEditing = true;
        $this->showModal = true;
    }
    
    public function delete($id)
    {
        Hairstyle::find($id)->delete();
        session()->flash('message', 'Hairstyle deleted successfully.');
        session()->flash('message_type', 'error');
    }

    public function exportToCsv()
    {
        $hairstyles = Hairstyle::with('category')->get();
        
        $filename = 'hairstyles-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($hairstyles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Description', 'Category', 'Created At']);
            
            foreach ($hairstyles as $hairstyle) {
                fputcsv($file, [
                    $hairstyle->id,
                    $hairstyle->name,
                    $hairstyle->description,
                    $hairstyle->category->name,
                    $hairstyle->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}