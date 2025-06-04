<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-2xl font-bold text-gray-800">Manage Rewards</h3>
        <button 
            wire:click="create"
            class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600 transition-colors duration-200 flex items-center gap-2">
            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white text-pink-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </span>
            Add New Item
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="w-full md:w-1/3 mb-4">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" wire:model="search" id="default-search" name="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Reward...">                </div>
            </div>

    <!-- DataTable -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('name')">
                        Name
                        @if ($sortField === 'name')
                            <span class="ml-1">{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('points_required')">
                        Points Required
                        @if ($sortField === 'points_required')
                            <span class="ml-1">{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Image
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('active_from')">
                        Active Period
                        @if ($sortField === 'active_from')
                            <span class="ml-1">{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($rewards as $reward)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $reward->name }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($reward->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($reward->points_required) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($reward->image_path)
                                <img src="{{ Storage::url($reward->image_path) }}" 
                                     alt="{{ $reward->name }}" 
                                     class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400">No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if ($reward->active_from && $reward->expiry_date)
                                {{ $reward->active_from->format('M d, Y') }} - {{ $reward->expiry_date->format('M d, Y') }}
                            @else
                                No period set
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $reward->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $reward->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button 
                                wire:click="edit({{ $reward->id }})"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                            </button>
                            <button 
                                class="text-red-600 hover:text-red-900"
                                onclick="if (confirm('Are you sure you want to delete this reward?')) { 
                                    @this.call('delete', {{ $reward->id }});
                                }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No rewards found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $rewards->links() }}
    </div>

    <!-- Modal Form -->
    <div class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: {{ $showModal ? 'block' : 'none' }}">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ $editMode ? 'Edit Reward' : 'Create New Reward' }}
                        </h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" 
                                   wire:model.defer="name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea 
                                wire:model.defer="description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Points Required</label>
                            <input type="number" 
                                   wire:model.defer="points_required"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            @error('points_required') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" 
                                   wire:model="image"
                                   class="mt-1 block w-full">
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Active From</label>
                                <input type="datetime-local" 
                                       wire:model.defer="active_from"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                @error('active_from') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <input type="datetime-local" 
                                       wire:model.defer="expiry_date"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                @error('expiry_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center mb-4">
                            <input type="checkbox" 
                                   wire:model.defer="is_active"
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            <label class="ml-2 block text-sm text-gray-900">Active</label>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pink-600 text-base font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $editMode ? 'Update' : 'Create' }}
                        </button>
                        <button type="button"
                                wire:click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>