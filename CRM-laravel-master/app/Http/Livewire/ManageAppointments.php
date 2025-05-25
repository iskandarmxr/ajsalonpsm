<?php

namespace App\Http\Livewire;

use App\Enums\UserRolesEnum;
use App\Enums\AppointmentStatusEnum;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAppointments extends Component
{

    use WithPagination;
    private $appointments;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $appointment;

    public $confirmingAppointmentAdd;

    public $confirmAppointmentCancellation  = false;
    public $confirmingAppointmentCancellation = false;

    public $showingAssignStaffModal = false;
    public $selectedAppointmentId;
    public $selectedStaffId;
    public $availableStaff = [];

    private $timeNow;

    public $selectFilter = 'all'; // can be 'pending' , 'confirmed' , 'completed', 'rejected', 'cancelled'

    private $userId;

    protected $rules = [
//        "appointment.name" => "required|string|max:255",
        'selectedStaffId' => 'required'
    ];

    public function updateAppointmentStatus($appointmentId, $status)
    {
        if (auth()->user()->role->name == "Manager" || auth()->user()->role->name == "Staff") {
            $appointment = Appointment::findOrFail($appointmentId);
            $appointment->status = AppointmentStatusEnum::from($status);
            $appointment->save();
        }
    }

    public function mount($userId = null, $selectFilter = 'all') {
        if (auth()->user()->role_id == UserRolesEnum::Customer->value) {
            $this->userId = auth()->user()->id;
        } else if (auth()->user()->role_id == UserRolesEnum::Staff->value || auth()->user()->role_id == UserRolesEnum::Manager->value) {
            $this->userId = $userId;
        }
        $this->selectFilter = $selectFilter;
        $this->timeNow = Carbon::now();
    }

    public function render()
    {
        $query = Appointment::query()
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('service', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectFilter !== 'all', function ($query) {
                $query->where('status', $this->selectFilter);
            });
            
        // Apply user filtering based on role
        if (auth()->user()->role_id == UserRolesEnum::Customer->value) {
            // For customers, always filter by their own ID
            $query->where('user_id', auth()->id());
        } else if ($this->userId) {
            // For staff/managers, filter by selected user if provided
            $query->where('user_id', $this->userId);
        }
        
        $appointments = $query->with(['user', 'service', 'timeSlot', 'location'])
            ->latest()
            ->paginate(10);

        return view('livewire.manage-appointments', [
            'appointments' => $appointments
        ]);
    }




//    public function confirmAppointmentEdit(Appointment $appointment) {
//        $this->appointment = $appointment;
//        $this->confirmingAppointmentAdd= true;
//    }
    public function confirmAppointmentCancellation() {
        $this->confirmingAppointmentCancellation = true;
    }

//    public function saveAppointment() {
//        $this->validate();
//
//        if (isset($this->appointment->id)) {
//            $this->appointment->save();
//        } else {
//            Appointment::create(
//                [
//                    'name' => $this->appointment['name'],
//                ]
//            );
//        }
//
//        $this->confirmingAppointmentAdd = false;
//        $this->appointment = null;
//    }

    public function cancelAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;


        if (auth()->user()->id == $this->appointment->user->id
        || auth()->user()->role->name == (UserRolesEnum::Staff->value || UserRolesEnum::Manager->value)) {
    
            $this->appointment->status = AppointmentStatusEnum::Cancelled;
            $this->appointment->save();
            $this->confirmingAppointmentCancellation = false;
        }
    }

//    public function confirmAppointmentAdd() {
//        $this->confirmingAppointmentAdd = true;
//    }
    public function showAssignStaffModal($appointmentId)
    {
        $this->selectedAppointmentId = $appointmentId;
        $this->availableStaff = User::where('role_id', UserRolesEnum::Staff->value)
            ->whereDoesntHave('assignedAppointments', function($query) {
                $query->whereIn('status', [
                    AppointmentStatusEnum::Pending->value,
                    AppointmentStatusEnum::Confirmed->value
                ]);
            })
            ->get();
        $this->showingAssignStaffModal = true;
    }

    public function assignStaff()
    {
        $this->validate();

        $appointment = Appointment::find($this->selectedAppointmentId);
        $appointment->assigned_staff_id = $this->selectedStaffId;
        $appointment->save();

        $this->showingAssignStaffModal = false;
        $this->selectedAppointmentId = null;
        $this->selectedStaffId = null;

        session()->flash('message', 'Staff assigned successfully.');
    }
}
