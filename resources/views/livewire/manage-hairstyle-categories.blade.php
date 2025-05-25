<div>
    <div>
        <div class="flex justify-between mx-7">
            <h2 class="text-2xl font-bold">Hairstyle Categories</h2>

            <x-button wire:click="confirmCategoryAdd" class="px-5 py-2 text-white bg-pink-500 rounded-md hover:bg-pink-600">
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                    <span>Add Hairstyle Category</span>
                </div>
            </x-button>
        </div>

        @if (session()->has('message'))
            <div class="px-4 py-2 mt-4 text-white bg-green-500 rounded-md">
                {{ session('message') }}
            </div>
        @endif

        <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
            <div class="w-1/3 float-right m-4">
                <div class="relative">
                    <input type="search" wire:model="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-pink-500 focus:border-pink-500" placeholder="Search Categories...">
                </div>
            </div>

            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-medium text-gray-900 w-1/6">Name</th>
                        <th class="px-6 py-4 font-medium text-gray-900 w-3/5">Description</th>
                        <th class="px-6 py-4 font-medium text-gray-900 w-1/5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $category->name }}</td>
                            <td class="px-6 py-4">{{ $category->description }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-4">
                                    <button wire:click="confirmCategoryEdit({{ $category->id }})" 
                                            wire:loading.attr="disabled"
                                            class="p-1.5 rounded-full text-yellow-600 hover:bg-yellow-50 transition-colors"
                                            title="Edit Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    <button wire:click="deleteCategory({{ $category->id }})" 
                                            wire:loading.attr="disabled"
                                            class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors"
                                            title="Delete Category">
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
                {{ $categories->links() }}
            </div>
        </div>

        <x-dialog-modal wire:model="confirmingCategoryAdd">
            <x-slot name="title">
                {{ $isEditing ? 'Edit Category' : 'Add Category' }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" wire:model="category.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200">
                        @error('category.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="category.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200"></textarea>
                        @error('category.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end gap-2">
                    <x-secondary-button wire:click="$set('confirmingCategoryAdd', false)">Cancel</x-secondary-button>
                    <x-button wire:click="saveCategory">Save</x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>