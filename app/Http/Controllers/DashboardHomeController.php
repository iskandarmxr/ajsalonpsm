<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdminDashboardHomeController;
use Illuminate\Http\Request;
use App\Enums\UserRolesEnum;

class DashboardHomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == UserRolesEnum::Manager->value) {
            return redirect()->route('admin.dashboard');
        } else if (auth()->user()->role_id == UserRolesEnum::Staff->value) {
            return redirect()->route('manageappointments');
        } else if (auth()->user()->role_id == UserRolesEnum::Customer->value) {
            return view('dashboard.appointments.history');
        }
        else {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to perform this action.');
        }
    }
}
