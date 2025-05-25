<?php
    use App\Enums\AppointmentStatusEnum;
    use App\Enums\UserRolesEnum;
?>

<div>
    <div>
        <div class="flex justify-between mx-7">
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

            <div class="w-full m-4 flex">

            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="pl-6 py-4 font-medium text-gray-900">Code</th>
                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">Service</th>
                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">Date & Time Slot</th>
                    @if(auth()->user()->role->name == 'Manager' || auth()->user()->role->name == 'Staff')
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900">Customer Info</th>
                    @endif
                    @if(auth()->user()->role->name == 'Manager' || auth()->user()->role->name == 'Staff')
                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">Status</th>
                    @if(auth()->user()->role->name == 'Manager' || auth()->user()->role->name == 'Staff')
                        <th scope="col" class="px-4 py-4 font-medium text-gray-900">Staff</th>
                        @if(auth()->user()->role->name == 'Manager')
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Action</th>
                        @endif
                    @endif
                    @endif
                </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4">{{ $appointment->appointment_code }}</td>
                            <td class="px-4 py-4">{{ $appointment->service->name }}</td>
                            <td class="px-6 py-4">
                                {{ $appointment->date }}<br>
                                <span class="text-gray-500">{{ $appointment->timeSlot->start_time }} - {{ $appointment->timeSlot->end_time }}</span>
                            </td>
                            
                            @if(auth()->user()->role->name == 'Manager' || auth()->user()->role->name == 'Staff')
                                <td class="px-6 py-4">
                                    <div>{{ $appointment->user->name }}</div>
                                    <div class="text-gray-500">{{ $appointment->user->email }}</div>
                                </td>
                            @endif
                            @if(auth()->user()->role->name == 'Manager' || auth()->user()->role->name == 'Staff')
                                <td class="px-6 py-4">
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
                                <td class="px-6 py-4">
                                    @if($appointment->assigned_staff)
                                        {{ $appointment->assigned_staff->name }}
                                    @else
                                        <span class="text-gray-500">No staff assigned</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role->name == 'Manager')
                                    <td class="px-6 py-4">
                                        @if($appointment->status->value === 'pending')
                                            <button wire:click="showAssignStaffModal({{ $appointment->id }})" 
                                                    class="px-3 py-1 text-sm text-white bg-pink-500 rounded-md hover:bg-pink-600">
                                                Assign Staff
                                            </button>
                                        @endif
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center">No Appointments Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-5">
                {{ $appointments->links() }}
            </div>



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

            <x-dialog-modal wire:model="showingAssignStaffModal">
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
                        <x-secondary-button wire:click="$set('showingAssignStaffModal', false)" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-button wire:click="assignStaff" wire:loading.attr="disabled">
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
    </div>
</div>

