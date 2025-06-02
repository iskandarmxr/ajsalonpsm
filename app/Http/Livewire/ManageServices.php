<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ManageServices extends Component

{

    use withPagination;
    use withFileUploads;

    public $confirmingServiceDeletion = false;
    public $confirmingServiceAdd = false;
    public $confirmingServiceEdit = false;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $newService, $image;

    protected function rules()
    {
        return [
            'newService.name' => 'required|string|min:1|max:255',
            'newService.slug' => 'nullable',
            'newService.description' => 'required|string|min:1|max:255',
            'newService.image' => 'nullable',
            'newService.price' => 'required|numeric|min:0',
            'newService.category_id' => 'required|exists:categories,id',
            'newService.notes' => 'nullable|string',
            'newService.allergens' => 'nullable|string',
            'newService.benefits' => 'nullable|string',
            'newService.aftercare_tips' => 'nullable|string',
            'newService.cautions' => 'nullable|string',
            'newService.is_hidden' => 'boolean',
            'image' => 'nullable|sometimes|file|image|mimes:jpg,jpeg,png,svg,gif|max:2048'
        ];
    }

    public function render()
    {

        $services = Service::when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('slug', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                ->orWhere('price', 'like', '%'.$this->search.'%')
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderByPrice('PriceLowToHigh')
            ->with('category')
            ->paginate(10);

        $categories = \App\Models\Category::all();

        return view('livewire.manage-services', compact('services'), compact('categories'));
    }

    public function confirmServiceDeletion($id)
    {
        $this->confirmingServiceDeletion = $id;


    }

    public function deleteService(Service $service)
    {
        $service->delete();

        session()->flash('message', 'Service successfully deleted.');
        $this->confirmingServiceDeletion = false;

        $this->emit('servicesUpdated');
    }


    public function confirmServiceAdd() {
        $this->reset(['newService']);
        $this->image = null;  // Reset image to null, so no stale filename remains
        $this->confirmingServiceAdd = true;
    }

    public function confirmServiceEdit( Service $service ) {
        $this->newService = $service->toArray();
        // Do NOT assign $this->image here, leave it null to mean no new upload yet
        $this->image = null;
        $this->confirmingServiceAdd = true;
        $this->emit('servicesUpdated');
    }

    public function exportToCsv()
    {
        $services = Service::with('category')->get();
        
        $filename = 'aj-salon-hairservices-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Description', 'Price', 'Category', 'Status', 'Created At']);
            
            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->name,
                    $service->description,
                    $service->price,
                    $service->category ? $service->category->name : 'N/A',
                    $service->is_hidden ? 'Hidden' : 'Visible',
                    $service->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function mount()
    {
        if (!auth()->user() || auth()->user()->role->name !== 'Manager') {
            abort(403, 'Only managers can manage services.');
        }
        return;
    }

    public function saveService() {
        $validatedData = $this->validate();

        try {
            if (isset($this->newService['id'])) {
                // Update existing service
                $service = Service::findOrFail($this->newService['id']);
                
                // Only update image if a new one is uploaded
                if ($this->image) {
                    // New file uploaded
                    $this->image->store('images', 'public');
                    $service->image = $this->image->hashName();
                } else {
                    // No new file, keep existing filename from $newService['image']
                    $service->image = $this->newService['image'] ?? null;
                }
                
                $service->update([
                    'name' => $this->newService['name'],
                    'slug' => \Str::slug($this->newService['name']),
                    'description' => $this->newService['description'],
                    'price' => $this->newService['price'],
                    'category_id' => $this->newService['category_id'],
                    'is_hidden' => $this->newService['is_hidden'] ?? false,
                    'allergens' => $this->newService['allergens'] ?? null,
                    'cautions' => $this->newService['cautions'] ?? null,
                    'benefits' => $this->newService['benefits'] ?? null,
                    'aftercare_tips' => $this->newService['aftercare_tips'] ?? null,
                    'notes' => $this->newService['notes'] ?? null

                ]);
            } else {
                // Create new service
                $imageName = null;
                if ($this->image) {
                    $this->image->store('images', 'public');
                    $imageName = $this->image->hashName();
                }
        
                Service::create([
                    'name' => $this->newService['name'],
                    'slug' => \Str::slug($this->newService['name']),
                    'description' => $this->newService['description'],
                    'price' => $this->newService['price'],
                    'category_id' => $this->newService['category_id'],
                    'is_hidden' => $this->newService['is_hidden'] ?? false,
                    'allergens' => $this->newService['allergens'] ?? null,
                    'cautions' => $this->newService['cautions'] ?? null,
                    'benefits' => $this->newService['benefits'] ?? null,
                    'aftercare_tips' => $this->newService['aftercare_tips'] ?? null,
                    'notes' => $this->newService['notes'] ?? null,
                    'image' => $imageName
                ]);
            }
    
            session()->flash('message', isset($this->newService['id']) ? 'Hair service successfully updated.' : 'Hair service successfully added.');
            $this->confirmingServiceAdd = false;
            $this->reset(['newService', 'image']);
    
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving service: ' . $e->getMessage());
            \Log::error('Service creation error: ' . $e->getMessage());
        }
        $this->emit('servicesUpdated');
    }
}
