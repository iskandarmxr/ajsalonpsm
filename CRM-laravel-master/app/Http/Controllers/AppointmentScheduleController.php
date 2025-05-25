<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentScheduleController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date') ? Carbon::parse($request->query('date')) : Carbon::now();
        $view = $request->query('view', 'month'); // Default to month view
        
        if ($view === 'week') {
            $startOfWeek = $date->copy()->startOfWeek();
            $endOfWeek = $date->copy()->endOfWeek();
            $appointments = Appointment::with(['user', 'service', 'timeSlot'])
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->orderBy('date')
                ->orderBy('time_slot_id')
                ->get()
                ->groupBy('date');
                
            return view('dashboard.appointment-schedule.index', compact('appointments', 'startOfWeek', 'view', 'date'));
        } else {
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            $appointments = Appointment::with(['user', 'service', 'timeSlot'])
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