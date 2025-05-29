<?php
    use App\Enums\AppointmentStatusEnum;
    use App\Enums\UserRolesEnum;
?>

<div>
    <div>
        <div class="flex justify-between mx-7 pt-4">
            <h2 class="text-2xl font-bold">
            @if(Auth::user()->role_id == UserRolesEnum::Customer->value)
                My
                @if ($selectFilter == 'pending')
                    Pending
                @elseif ($selectFilter == 'confirmed')
                    Confirmed
                @elseif ($selectFilter == 'completed')
                    Completed
                @elseif ($selectFilter == 'rejected')
                    Rejected
                @elseif ($selectFilter == 'cancelled')
                    Cancelled
                @endif
                Appointments
            @else
                @if ($selectFilter == 'pending')
                    Pending
                @elseif ($selectFilter == 'confirmed')
                    Confirmed
                @elseif ($selectFilter == 'completed')
                    Completed
                @elseif ($selectFilter == 'rejected')
                    Rejected
                @elseif ($selectFilter == 'cancelled')
                    Cancelled
                @endif
                Appointments List
            @endif
            </h2>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <select wire:model="selectFilter" class="block w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 rounded leading-tight focus:outline-none">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                <x-button wire:click="exportToCSV" class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export to CSV
                </x-button>
                @endif
            </div>

{{--            <x-button wire:click="confirmAppointmentAdd"  class="px-5 py-2 text-white bg-pink-500 rounded-md hover:bg--600">--}}
{{--                Create--}}
{{--            </x-button>--}}
        </div>
        <div class="mt-4">
            @if (session()->has('message'))
                <div class="px-4 py-2 text-white bg-green-500 rounded-md">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
            <div class="w-full md:w-1/3 float-none md:float-right m-4">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" wire:model="search" id="default-search" name="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Appointment...">                </div>
            </div>

            <div class="w-full m-4 overflow-x-auto">
                <table id="appointmentsTable" class="w-full border-collapse bg-white text-left text-sm text-gray-500 min-w-[800px] md:min-w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="pl-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Code</th>
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Service</th>
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Location</th>
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Date & Time Slot</th>
                            @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Staff->value)
                                <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Customer Info</th>
                            @endif
                        @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Staff->value || Auth::user()->role_id == UserRolesEnum::Customer->value)
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Status</th>
                        @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Customer->value)
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200 whitespace-nowrap">Staff</th>
                            @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                                <th scope="col" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap">Action</th>
                            @endif
                        @endif
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->appointment_code }}</td>
                            <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->service->name }}</td>
                            <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->location->name }}</td>
                            <td class="px-4 py-4 border-r border-gray-200">
                                {{ $appointment->date }}<br>
                                <span class="text-gray-500">{{ $appointment->timeSlot->start_time }} - {{ $appointment->timeSlot->end_time }}</span>
                            </td>
                            
                            @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Staff->value)
                                <td class="px-4 py-4 border-r border-gray-200">
                                    <div>{{ $appointment->user->name }}</div>
                                    <div class="text-gray-500">{{ $appointment->user->email }}</div>
                                </td>
                            @endif
                            @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                                <td class="px-4 py-4 border-r border-gray-200">
                                    <select wire:change="updateAppointmentStatus({{ $appointment->id }}, $event.target.value)" 
                                            class="rounded-md border-gray-300 text-sm font-semibold
                                            @if($appointment->status->value === 'pending') text-gray-800 bg-gray-50 @endif
                                            @if($appointment->status->value === 'confirmed') text-sky-800 bg-sky-50 @endif
                                            @if($appointment->status->value === 'completed') text-emerald-800 bg-emerald-50 @endif
                                            @if($appointment->status->value === 'rejected') text-orange-800 bg-orange-50 @endif
                                            @if($appointment->status->value === 'cancelled') text-rose-800 bg-rose-50 @endif">
                                        @foreach(AppointmentStatusEnum::cases() as $status)
                                            <option value="{{ $status->value }}" 
                                                    {{ $appointment->status === $status ? 'selected' : '' }}
                                                    class="
                                                    @if($status->value === 'pending') text-gray-800 bg-gray-50 @endif
                                                    @if($status->value === 'confirmed') text-sky-800 bg-sky-50 @endif
                                                    @if($status->value === 'completed') text-emerald-800 bg-emerald-50 @endif
                                                    @if($status->value === 'rejected') text-orange-800 bg-orange-50 @endif
                                                    @if($status->value === 'cancelled') text-rose-800 bg-rose-50 @endif">
                                                {{ ucfirst($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            @elseif(Auth::user()->role_id == UserRolesEnum::Staff->value || Auth::user()->role_id == UserRolesEnum::Customer->value)
                                <td class="px-4 py-4 border-r border-gray-200">
                                    <span class="px-3 py-1 text-sm rounded-full
                                            @if($appointment->status->value === 'pending') text-gray-800 bg-gray-50 @endif
                                            @if($appointment->status->value === 'confirmed') text-sky-800 bg-sky-50 @endif
                                            @if($appointment->status->value === 'completed') text-emerald-800 bg-emerald-50 @endif
                                            @if($appointment->status->value === 'rejected') text-orange-800 bg-orange-50 @endif
                                            @if($appointment->status->value === 'cancelled') text-rose-800 bg-rose-50 @endif">
                                            {{ ucfirst($appointment->status->value) }}
                                        </span>
                                </td>
                            @endif
                                @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Customer->value )
                                <td class="px-4 py-4 border-r border-gray-200">
                                    @if($appointment->assigned_staff)
                                        {{ $appointment->assigned_staff->name }}
                                    @else
                                        <span class="text-gray-500">No staff assigned</span>
                                    @endif
                                </td>
                                @endif
                                @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                                    <td class="px-4 py-4 justify-center items-center">
                                        @if($appointment->status->value === 'pending')
                                            @if(!$appointment->assigned_staff)
                                                <button wire:click="showAssignStaffModal({{ $appointment->id }})" 
                                                        class="text-pink-500 hover:text-pink-600" 
                                                        title="Assign Staff">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button wire:click="unassignStaff({{ $appointment->id }})" 
                                                        class="text-red-500 hover:text-red-600" 
                                                        title="Unassign Staff">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                    </svg>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-4 text-center">No Appointments Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- <div class="p-5">
                {{ $appointments->links() }}
            </div> -->



            <x-dialog-modal wire:model="confirmingAppointmentCancellation">
                <x-slot name="title">
                    {{ __('Cancel Appointment') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to cancel the appointment?') }}

                </x-slot>

                <x-slot name="footer">
                    <div class="flex gap-3">
                        <x-secondary-button wire:click="$set('confirmingAppointmentCancellation', false)" wire:loading.attr="disabled">
                            {{ __('Back') }}
                        </x-secondary-button>

                        <x-danger-button wire:click="cancelAppointment({{ $confirmingAppointmentCancellation }})" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-danger-button>
                    </div>

                </x-slot>
            </x-dialog-modal>

            <x-dialog-modal wire:model="showingAssignStaffModal" maxWidth="xl">
                <x-slot name="title">
                    {{ __('Assign Staff to Appointment') }}
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <label for="staff" class="block text-sm font-medium text-gray-700">Select Staff</label>
                        <select wire:model="selectedStaffId" id="staff" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Select a staff member</option>
                            @foreach($availableStaff as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedStaffId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex gap-3">
                        <x-secondary-button wire:click="$set('showingAssignStaffModal', false)" onclick="setTimeout(function(){ window.location.reload(); }, 100);" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-button wire:click="assignStaff" onclick="setTimeout(function(){ window.location.reload(); }, 1000);" wire:loading.attr="disabled">
                            {{ __('Assign') }}
                        </x-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
{{--            <x-dialog-modal wire:model="confirmingAppointmentAdd">--}}
{{--                <x-slot name="title">--}}
{{--                    {{ isset($this->appointment->id) ? 'Edit Appointment' : 'Add Appointment' }}--}}
{{--                </x-slot>--}}

{{--                <x-slot name="content">--}}
{{--                    <div>--}}
{{--                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>--}}
{{--                        <input type="text" wire:model="appointment.name" id="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">--}}
{{--                        @error('appointment.name') <span class="text-red-500">{{ $message }}</span>@enderror--}}
{{--                    </div>--}}

{{--                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">--}}
{{--                        <div class="flex justify-end mt-4 gap-2">--}}
{{--                            <x-secondary-button wire:click="$set('confirmingAppointmentAdd', false)" wire:loading.attr="disabled">--}}
{{--                                {{ __('Cancel') }}--}}
{{--                            </x-secondary-button>--}}
{{--                            <x-button wire:click="saveAppointment">Save</x-button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </x-slot>--}}
{{--                <x-slot name="footer">--}}
{{--                </x-slot>--}}
{{--            </x-dialog-modal>--}}
        </div>
        <!-- <div class="p-5">
                {{ $appointments->links() }}
            </div> -->
    </div>
    <div class="p-5">
                {{ $appointments->links() }}
            </div>
    
</div>

