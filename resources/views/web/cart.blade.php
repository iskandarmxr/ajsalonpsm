<x-app-layout>
    <div class="bg-gray-100 py-8" x-data="{ showCheckoutConfirmation: false }">
        <div class="container mx-auto px-4 md:w-11/12">
            <h1 class="text-2xl font-semibold mb-4">Cart</h1>
            @if(session('unavailable_time_slots'))


                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">The following time slots are no longer available. Please remove them from your cart to continue.</span>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">


                        @foreach(session('unavailable_time_slots') as $unavailable_time_slot)
                            <li>{{ $unavailable_time_slot['date'] }}: {{ date('g:i a', strtotime($unavailable_time_slot['start_time'])) }} - {{ date('g:i a', strtotime($unavailable_time_slot['end_time'])) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full min-w-max">
                                <thead>
                                <tr>
                                    <th class="text-left font-semibold px-6 py-3">Service</th>
                                    <th class="text-left font-semibold px-6 py-3">Price</th>
                                    <th class="text-left font-semibold px-6 py-3">Date</th>
                                    <th class="text-left font-semibold px-6 py-3">Time Slot</th>
                                    <th class="text-left font-semibold px-6 py-3">Location</th>
                                    <th class="text-left font-semibold px-6 py-3"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($cart->services))
                                @foreach($cart->services as $service)
                                    <tr>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <img class="h-16 w-16 mr-4" src="{{ asset('storage/images/' . $service->image) }}" alt="{{ $service->name . ' image'}}">
                                            <span class="font-semibold"> {{ $service->name }}</span>
                                        </div>
                                    </td>
                                        <td class="py-4 px-6">RM {{ number_format($service->price, 2, '.', ',') }}</td>
                                        <td class="py-4 px-6">
                                          {{ $service->pivot->date}}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ date('g:i a', strtotime( $service->pivot->start_time)) }}
                                              -
                                            {{ date('g:i a', strtotime( $service->pivot->end_time)) }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <!-- {{ $service->locations->first()->name }} -->
                                            {{ App\Models\Location::find($service->pivot->location_id)->name }}
                                        </td>
                                        <form action="{{ route('cart.remove-item', [
                                            'cart_service_id' => $service->pivot->id,
                                            ]) }}"
                                            method="post">
                                            @csrf
                                            <td class="py-4 px-6">
                                                <button type="submit" class="text-red-500 hover:text-red-600 font-semibold">Remove</button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center pt-8">No items in cart</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Summary</h2>
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>RM {{ number_format($cart?->total, 2, '.', ',') }}</span>

                        </div>
{{--                        <div class="flex justify-between mb-2">--}}
{{--                            <span>Taxes</span>--}}
{{--                            <span>$1.99</span>--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-between mb-2">--}}
{{--                            <span>Shipping</span>--}}
{{--                            <span>$0.00</span>--}}
{{--                        </div>--}}
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">RM {{ number_format($cart?->total, 2, '.', ',') }}</span>
                        </div>
                        <button @click="showCheckoutConfirmation = true" class="bg-pink-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Book</button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showCheckoutConfirmation" x-cloak class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center">
            <div class="fixed inset-0 transition-opacity -z-10" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg p-4 max-w-md mx-auto"  @click.outside="showCheckoutConfirmation = false" >
                <h2 class="text-xl font-semibold">Confirm Booking</h2>
                <p>Are you sure you want to book?</p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="showCheckoutConfirmation = false" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none">
                        Cancel
                    </button>
                    <form action="{{route('cart.checkout')}}" method="post">
                        @csrf
                        <button class="px-4 py-2 text-sm font-medium text-white bg-pink-600 border border-transparent rounded-md hover:bg-pink-700 focus:outline-none">
                            Confirm
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>




</x-app-layout>
