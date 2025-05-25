<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Location;
use App\Models\Service;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class AddingServiceToCart extends Component
{
    public $service;
    public $timeSlots;

    public $locations;

    public $selectedLocation;
    public $selectedTimeSlot;
    public $selectedDate;

    public function mount(Service $service)
    {
        $this->service = $service;
        $this->timeSlots = TimeSlot::all();
        $this->locations = Location::where('status', true)->get();
        $this->timeSlots->map(function ($timeSlot) {
            $timeSlot->available = true;
        });
    }
    public function render()
    {
        return view('livewire.adding-service-to-cart');
    }

    // when date is selected, get the time slots
    // if there are appointments with that slot in a day, add an attribute called available

    public function updatedSelectedLocation($selectedLocation)
    {
        $this->displayUnvailableTimeSlots();

    }

    public function updatedSelectedDate($selectedDate)
    {
        // get the unavailable time slots
        if ( $this->selectedLocation == null ) {
            $this->selectedLocation = $this->locations->first()->id;
        }

        $this->displayUnvailableTimeSlots();

    }

    private function displayUnvailableTimeSlots() {
        $unavailableTimeSlots = Appointment::get()
            ->where('date', $this->selectedDate)
            ->where('location_id', $this->selectedLocation)
            ->pluck('time_slot_id')->toArray();

        // check the cart of the user
        $cart = auth()->user()?->cart?->where('is_paid', false)->first();

        // if the selectedDate is today's date, then the time slots before the current time should be unavailable
        $now = Carbon::now();
        if ($now->toDateString() == $this->selectedDate) {
            $slotsBeforeCurrentTime = TimeSlot::where('start_time', '<', $now->toTimeString())
                ->pluck('id')->toArray();

//            Log::info("slots before current time", $slotsBeforeCurrentTime);
//            Log::info("unavailable time slots", $unavailableTimeSlots);

            $unavailableTimeSlots = array_merge($unavailableTimeSlots, $slotsBeforeCurrentTime);
//            Log::info("unavailable time slots after merge", $unavailableTimeSlots);
        }
        // if the user has a cart, check the cart items
        if ( $cart ) {
            $inCartSameTimeDate =  $cart->services()
                ->where('date', $this->selectedDate)
                ->pluck('time_slot_id')->toArray();
            $unavailableTimeSlots = array_merge($unavailableTimeSlots, $inCartSameTimeDate);

        }
//        Log::info("Final unavailable time slots :", $unavailableTimeSlots);


//        check the time slots that are not in the

        foreach ( $this->timeSlots as $timeSlot ) {
            if ( !in_array($timeSlot->id, $unavailableTimeSlots) ) {
                $timeSlot->available = true;
            } else {
                $timeSlot->available = false;
            }

            if ($this->selectedTimeSlot != null) {
                if ( in_array($this->selectedTimeSlot, $unavailableTimeSlots) ) {
                    $this->selectedTimeSlot = null;
                }
            }
        }
    }

    // add the service to the cart
    public function addToCart()
    {
        if($this->service->is_hidden) {
            return redirect()->back();
        }
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Validate required fields
        if (!$this->selectedDate || !$this->selectedTimeSlot || !$this->selectedLocation) {
            session()->flash('error', 'Please select date, time slot and location');
            return redirect()->back();
        }

        // Get or create cart with proper error handling
        try {
            $cart = auth()->user()->cart()->where('is_paid', false)->first();
            if (!$cart) {
                $cart = auth()->user()->cart()->create([
                    'is_paid' => false,
                    'is_cancelled' => false,
                    'is_abandoned' => false,
                    'total' => 0
                ]);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating cart. Please try again.');
            return redirect()->back();
        }

        // Validate time slot availability
        $timeSlot = TimeSlot::find($this->selectedTimeSlot);
        if (!$timeSlot) {
            session()->flash('error', 'Selected time slot is invalid');
            return redirect()->back();
        }

        // Check for existing appointments and cart items
        $existingBooking = Appointment::where('date', $this->selectedDate)
            ->where('time_slot_id', $this->selectedTimeSlot)
            ->where('location_id', $this->selectedLocation)
            ->exists();

        $cartItem = $cart->services()
            ->where('date', $this->selectedDate)
            ->where('time_slot_id', $this->selectedTimeSlot)
            ->where('location_id', $this->selectedLocation)
            ->exists();

        if ($existingBooking || $cartItem) {
            session()->flash('error', 'This time slot is no longer available');
            return redirect()->back();
        }

        try {
            // Add service to cart with proper error handling
            $cart->services()->attach($this->service->id, [
                'time_slot_id' => $this->selectedTimeSlot,
                'date' => $this->selectedDate,
                'start_time' => $timeSlot->start_time,
                'end_time' => $timeSlot->end_time,
                'location_id' => $this->selectedLocation,
                'price' => $this->service->price,
            ]);

            // Update cart total
            $cart->total = $cart->services()->sum(DB::raw('cart_service.price'));
            $cart->save();

            session()->flash('message', 'Service added to cart successfully');
            return redirect()->route('cart');
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding service to cart. Please try again.');
            return redirect()->back();
        }
    }

}
