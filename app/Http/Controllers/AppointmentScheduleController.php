<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\UserRolesEnum;

class AppointmentScheduleController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date') ? Carbon::parse($request->query('date')) : Carbon::now();
        $view = $request->query('view', 'month'); // Default to month view
        
        // Get the logged-in user
        $user = auth()->user();
        
        // Base query with relationships
        $query = Appointment::with(['user', 'service', 'timeSlot']);
        
        // If user is staff, only show their assigned appointments
        if ($user->role_id === UserRolesEnum::Staff->value) {
            $query->where('assigned_staff_id', $user->id);
        }
        
        if ($view === 'week') {
            $startOfWeek = $date->copy()->startOfWeek();
            $endOfWeek = $date->copy()->endOfWeek();
            $appointments = $query
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->orderBy('date')
                ->orderBy('time_slot_id')
                ->get()
                ->groupBy('date');
                
            return view('dashboard.appointment-schedule.index', compact('appointments', 'startOfWeek', 'view', 'date'));
        } else {
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            $appointments = $query
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->orderBy('date')
                ->orderBy('time_slot_id')
                ->get()
                ->groupBy('date');
                
            return view('dashboard.appointment-schedule.index', 
                compact('appointments', 'startOfMonth', 'endOfMonth', 'view', 'date')
            );
        }
    }
}