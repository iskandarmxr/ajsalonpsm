<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;

class LoyaltyProgramPageController extends Controller
{
    //
    public function show()
    {
        $rewards = Reward::all(); // Assuming you have a Reward model
        return view('web.loyalty-program', compact('rewards'));
    }
}
