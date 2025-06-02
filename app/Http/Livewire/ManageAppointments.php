<?php

namespace App\Http\Livewire;

use App\Enums\UserRolesEnum;
use App\Enums\AppointmentStatusEnum;
use App\Models\Appointment;
use App\Models\User;
use App\Models\CustomerLoyaltyPoints;
use App\Models\LoyaltySetting;
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

    public $showingReceiptModal = false;
    public $currentReceiptPath = null;
    public $currentReceiptType = null;

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
            $oldStatus = $appointment->status;
            
            \Log::info('Updating appointment status', [
                'appointment_id' => $appointmentId,
                'old_status' => $oldStatus->value,
                'new_status' => $status,
                'appointment_total' => $appointment->total,
                'user_id' => $appointment->user_id
            ]);

            $appointment->status = AppointmentStatusEnum::from($status);
            $appointment->save();

            // Handle loyalty points when appointment is completed
            if ($status === 'completed' && $oldStatus->value !== 'completed') {
                \Log::info('Processing loyalty points for completed appointment');
                
                $loyaltyPoints = CustomerLoyaltyPoints::firstOrCreate(
                    ['user_id' => $appointment->user_id],
                    [
                        'points_balance' => 0,
                        'total_points_earned' => 0,
                        'points_redeemed' => 0
                    ]
                );
                
                $settings = LoyaltySetting::getActiveSettings();
                \Log::info('Loyalty settings', [
                    'settings' => $settings ? [
                        'points_per_appointment' => $settings->points_per_appointment,
                        'minimum_spend' => $settings->minimum_spend
                    ] : null
                ]);

                if ($settings && $appointment->total >= $settings->minimum_spend) {
                    $pointsEarned = $settings->points_per_appointment;
                    $loyaltyPoints->addPoints($pointsEarned);
                    
                    \Log::info('Added loyalty points', [
                        'points_earned' => $pointsEarned,
                        'new_balance' => $loyaltyPoints->points_balance,
                        'total_earned' => $loyaltyPoints->total_points_earned
                    ]);

                    session()->flash('message', "Added {$pointsEarned} loyalty points for completed appointment.");
                } else {
                    \Log::info('No points added - conditions not met', [
                        'has_settings' => (bool)$settings,
                        'appointment_total' => $appointment->total,
                        'minimum_spend' => $settings ? $settings->minimum_spend : null
                    ]);
                }
            }
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
                })
                ->orWhereHas('service', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('appointment_code', 'like', '%' . $this->search . '%')
                ->orWhereHas('location', function ($query) {
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
            // For managers, filter by selected user if provided
            $query->where('user_id', $this->userId);
        } else if(auth()->user()->role_id == UserRolesEnum::Staff->value) {
            // For staff, show only appointments assigned to them
            $query->where('assigned_staff_id', auth()->id());
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

    public function unassignStaff($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment) {
            $appointment->assigned_staff_id = null;
            $appointment->save();
            session()->flash('message', 'Staff unassigned successfully.');
        }
    }

    public function showReceiptModal($receiptPath)
    {
        $this->currentReceiptPath = $receiptPath;
        
        // Determine file type based on extension
        $extension = pathinfo($receiptPath, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            $this->currentReceiptType = 'image';
        } elseif (strtolower($extension) === 'pdf') {
            $this->currentReceiptType = 'pdf';
        } else {
            $this->currentReceiptType = 'unknown';
        }
        
        $this->showingReceiptModal = true;
    }

    public function exportToCSV()
    {
        $appointments = $this->getFilteredAppointments();

        $filename = 'aj-salon-appointments (' . date('Y-m-d') . ').csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['Code', 'Service', 'Location', 'Date', 'Time Slot', 'Status', 'Staff'];
        
        $callback = function() use ($appointments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($appointments as $appointment) {
                $row = [
                    $appointment->appointment_code,
                    $appointment->service->name,
                    $appointment->location->name,
                    Carbon::parse($appointment->date)->format('d/m/Y'),
                    $appointment->timeSlot->start_time . ' - ' . $appointment->timeSlot->end_time,
                    ucfirst($appointment->status->value),
                    $appointment->assigned_staff ? $appointment->assigned_staff->name : 'No staff assigned'
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getFilteredAppointments()
    {
        $query = Appointment::query()
            ->with(['service', 'location', 'timeSlot', 'assigned_staff']);

        if ($this->selectFilter !== 'all') {
            $query->where('status', $this->selectFilter);
        }

        return $query->get();
    }
}
