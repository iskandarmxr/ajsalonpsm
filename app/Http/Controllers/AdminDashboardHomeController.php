<?php

namespace App\Http\Controllers;

use App\Enums\UserRolesEnum;
use App\Models\Appointment;
use App\Models\Deal;
use App\Models\Location;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\AppointmentStatusEnum;
use Illuminate\Http\Request;

class AdminDashboardHomeController extends Controller
{
    public function index()
    {
        $todayDate = Carbon::today()->format('j F, Y');

        $totalCustomers = User::where('role_id', UserRolesEnum::Customer->value)->count();
        $totalStaffs = User::where('role_id', UserRolesEnum::Staff->value)->count();
        $totalManagers = User::where('role_id', UserRolesEnum::Manager->value)->count();

        // Add new appointment status counters
        $pendingAppointments = Appointment::where('status', AppointmentStatusEnum::Pending->value)->count();
        $confirmedAppointments = Appointment::where('status', AppointmentStatusEnum::Confirmed->value)->count();
        $completedAppointments = Appointment::where('status', AppointmentStatusEnum::Completed->value)->count();
        $rejectedAppointments = Appointment::where('status', AppointmentStatusEnum::Rejected->value)->count();
        $cancelledAppointments = Appointment::where('status', AppointmentStatusEnum::Cancelled->value)->count();

        $totalServicesActive = Service::where('is_hidden', 0)->count();
        $totalServices = Service::count();

        $totalUpcomingDeals = Deal::where('start_date', '<', $todayDate)->count();
        $totalOngoingDeals = Deal::where('start_date', '<=', $todayDate)->where('end_date', '>=', $todayDate)->count();

        // dd($totalCustomers, $totalEmployees, $totalServicesActive, $totalServices, $totalUpcommingDeals, $totalOngoingDeals);

        $totalUpcomingAppointments = Appointment::where('date', '>', $todayDate)->count();
        $todaysAppointments = Appointment::where('date', $todayDate)->count();
        $tommorowsAppointments = Appointment::where('date', Carbon::today()->addDay()->toDateTime())->count();
        $weeklyAppointments = Appointment::whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $monthlyAppointments = Appointment::whereBetween('date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();

        $bookingRevenueThisMonth = Appointment::where('created_at', '>', Carbon::today()->subMonth()->toDateTime())->where('status', '!=', 0)->sum('total');
        $bookingRevenueLastMonth = Appointment::where('created_at', '>', Carbon::today()->subMonths(2)->toDateTime())->where('created_at', '<', Carbon::today()->subMonth()->toDateTime())->where('status', '!=', 0)->sum('total');
        $percentageRevenueChangeLastMonth = 0;
        if ($bookingRevenueLastMonth != 0) {
            $percentageRevenueChangeLastMonth = ($bookingRevenueThisMonth - $bookingRevenueLastMonth) / $bookingRevenueLastMonth * 100;
        } else {
            $percentageRevenueChangeLastMonth = 100;
        }


        $todaysSchedule = Appointment::orderBy('start_time', 'asc')
                ->where('date', $todayDate)
                ->where('status', '!=', 0)
                ->orderBy('time_slot_id', 'asc')
                ->where('status', '!=', 0)
                ->with('service', 'timeSlot', 'user')
                ->get();

        $tommorowsSchedule = Appointment::orderBy('start_time', 'asc')
                ->where('date', Carbon::today()->addDay()->toDateTime())
                ->where('status', '!=', 0)
                ->orderBy('time_slot_id', 'asc')
                ->where('status', '!=', 0)
                ->with('service', 'timeSlot', 'user')
                ->get();

        $timeSlots = TimeSlot::all();

        $locations = Location::all();
        $totalLocations = Location::count();

        $recentAppointments = Appointment::with(['user', 'service', 'timeSlot', 'location'])
            ->latest()
            ->take(5)
            ->get();

        // Total sales for today
        $totalSalesToday = Appointment::where('status', AppointmentStatusEnum::Completed->value)
            ->whereDate('date', Carbon::today())
            ->sum('total');
        
        // Total sales for this week (starting Monday)
        $totalSalesThisWeek = Appointment::where('status', AppointmentStatusEnum::Completed->value)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total');
        
        // Total sales for this month
        $totalSalesThisMonth = Appointment::where('status', AppointmentStatusEnum::Completed->value)
            ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('total');
        
        // Total sales for this year
        $totalSalesThisYear = Appointment::where('status', AppointmentStatusEnum::Completed->value)
            ->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('total');



        return view('dashboard.admin-employee', [
            'todayDate' => $todayDate,
            'totalCustomers' => $totalCustomers,
            'totalStaffs' => $totalStaffs,
            'totalManagers' => $totalManagers,
            'pendingAppointments' => $pendingAppointments,
            'confirmedAppointments' => $confirmedAppointments,
            'completedAppointments' => $completedAppointments,
            'rejectedAppointments' => $rejectedAppointments,
            'cancelledAppointments' => $cancelledAppointments,
            'totalServicesActive' => $totalServicesActive,
            'totalServices' => $totalServices,
            'totalUpcomingDeals' => $totalUpcomingDeals,
            'totalOngoingDeals' => $totalOngoingDeals,
            'totalUpcomingAppointments' => $totalUpcomingAppointments,
            'todaysAppointments' => $todaysAppointments,
            'tommorowsAppointments' => $tommorowsAppointments,
            'weeklyAppointments'=> $weeklyAppointments,
            'monthlyAppointments'=> $monthlyAppointments,
            'bookingRevenueThisMonth' => $bookingRevenueThisMonth,
            'percentageRevenueChangeLastMonth' => $percentageRevenueChangeLastMonth,
            'todaysSchedule' => $todaysSchedule,
            'tomorrowsSchedule' => $tommorowsSchedule,
            'timeSlots' => $timeSlots,
            'locations' => $locations,
            'totalLocations' => $totalLocations,
            'recentAppointments' => $recentAppointments,
            'totalSalesToday' => $totalSalesToday,
            'totalSalesThisWeek' => $totalSalesThisWeek,
            'totalSalesThisMonth' => $totalSalesThisMonth,
            'totalSalesThisYear' => $totalSalesThisYear,
        ]);
    }
}
