<div>
    <div class="flex justify-between mx-7">
        <h2 class="text-2xl font-bold">Services</h2>

        <x-button wire:click="confirmServiceAdd" class="px-5 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
            <div class="flex items-center gap-2">
                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </span>
                <span>Add Hair Service</span>
            </div>
        </x-button>
    </div>
    
    @if (session()->has('message'))
        <div class="px-4 py-2 text-white bg-green-500 rounded-md mt-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
        <table id="servicesTable" class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="pl-6 py-4 font-medium text-gray-900">ID</th>
                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">Service</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Photo</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Description</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Price</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Category</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Visibility</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($services as $service)
                <tr class="hover:bg-gray-50">
                <td class="pl-6 py-4  max-w-0">{{ $service->id }}</td>

                <th class="flex gap-3 px-6 py-4 font-normal text-gray-900  max-w-0">

                    <div class="font-medium text-gray-700">{{ $service->name}}</div>

                </th>
                <td class="px-6 py-4 max-w-0">
                    <div class="font-medium text-gray-700">
                        @if($service->image)
                            <img src="{{ asset('storage/images/' . $service->image) }}" alt="{{ $service->name }}" class="mt-4 w-20">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </div>
                </td>

                <td class="px-6 py-4 max-w-0">{{ $service->description }}</td>

                <td class="px-6 py-4  max-w-0">
                    <div class="font-medium text-gray-700">{{ $service->price}}</div>
                </td>
                <td class="px-6 py-4  max-w-0">
{{--                    @dd($service->category->name)--}}
                    <div class="font-medium text-gray-700">{{ $service->category?->name}}</div>
                </td>
                <td class="px-6 py-4 ">
                    <div>

                    @if($service->is_hidden == true)
                        <span
                        class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-600"
                      >
                        <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                        Hidden
                      </span>
                    @else
                        <span
                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-600"
                        >
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                        Visible
                        </span>
                    @endif

                    </div>
                </td>
                <td>
                <div class="flex gap-2">
                        <a href="{{ route('view-service', ['slug' => $service->slug ]) }}" 
                           class="p-1.5 rounded-full text-blue-600 hover:bg-blue-50 transition-colors"
                           title="View Service">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>

                        <button wire:click="confirmServiceEdit({{ $service->id }})" 
                                wire:loading.attr="disabled"
                                class="p-1.5 rounded-full text-yellow-600 hover:bg-yellow-50 transition-colors"
                                title="Edit Service">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>

                        <button wire:click="confirmServiceDeletion({{ $service->id }})" 
                                wire:loading.attr="disabled"
                                class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors"
                                title="Delete Service">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach

          </tbody>
        </table>
        <div class="p-5">
          {{ $services->links() }}
        </div>



        <x-dialog-modal wire:model="confirmingServiceDeletion">
            <x-slot name="title">
                {{ __('Delete Service') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the service?') }}

            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                <x-secondary-button wire:click="$set('confirmingServiceDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                    <x-danger-button wire:click="deleteService({{ $confirmingServiceDeletion }})" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </div>

            </x-slot>
        </x-dialog-modal>


        <x-dialog-modal wire:model="confirmingServiceAdd">
            <x-slot name="title">
                {{-- {{ __('Add a new service') }} --}}
                {{ isset($newService->id) ? 'Edit Service' : 'Add Service' }}
            </x-slot>

            <x-slot name="content">
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="newService.name" id="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('newService.name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" wire:model="newService.description"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('newService.description') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="text" wire:model="newService.price" id="price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                @error('newService.price') <span class="text-red-500">{{ $message }}</span>@enderror

                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>

                                <select wire:model="newService.category_id" id="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option disabled selected value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name}}</option>
                                    @endforeach
                                    @error('newService.category_id') <span class="text-red-500">{{ $message }}</span>@enderror
                                </select>
                            </div>
                        </div>
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label for="allergens" class="block text-sm font-medium text-gray-700">Allergens</label>
                                <textarea id="allergens" wire:model="newService.allergens"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('newService.allergens') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="cautions" class="block text-sm font-medium text-gray-700">Cautions</label>
                                <textarea id="cautions" wire:model="newService.benefits"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('newService.cautions') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits</label>
                                <textarea id="benefits" wire:model="newService.benefits"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('newService.benefits') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="aftercare_tips" class="block text-sm font-medium text-gray-700">Aftercare Tips</label>
                                <textarea id="aftercare_tips" wire:model="newService.aftercare_tips"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('newService.aftercare_tips') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" wire:model="newService.notes"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('newService.notes') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="is_hidden" class="block text-sm font-medium text-gray-700">Is Hidden</label>

                            <input type="checkbox" wire:model="newService.is_hidden" id="is_hidden">
                            @error('newService.is_hidden') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>


                        @if(auth()->user()->role->name === 'Manager')
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" wire:model="image" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('image') <span class="text-red-500">{{ $message }}</span>@enderror

                                @if ($image)
                                    @if (is_object($image) && method_exists($image, 'temporaryUrl'))
                                        <img src="{{ $image->temporaryUrl() }}" class="mt-4" width="200">
                                    @elseif (is_string($image))
                                        <img src="{{ asset('storage/images/' . $image) }}" class="mt-4" width="200">
                                    @endif
                                @endif
                            </div>
                        @endif


                        <div class="flex justify-end mt-4 gap-2">
                            <x-secondary-button wire:click="$set('confirmingServiceAdd', false)" wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-button wire:click="saveService">{{ __('Save') }}</x-button>
                        </div>
                    </div>
            </x-slot>

            <x-slot name="footer">


            </x-slot>
        </x-dialog-modal>
</div>
</div>

<!-- Add this script at the bottom of the file -->
<script>
    document.addEventListener('livewire:load', function () {
        let table = new DataTable('#servicesTable', {
            responsive: true,
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                search: "Search services:"
            }
        });

        // Re-initialize DataTable when Livewire updates the DOM
        Livewire.on('servicesUpdated', () => {
            table.destroy();
            table = new DataTable('#servicesTable', {
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']],
                language: {
                    search: "Search services:"
                }
            });
        });
    });
</script>
</div>
</div>
