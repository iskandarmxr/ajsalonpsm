<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4 md:w-11/12">
            <h1 class="text-2xl font-semibold mb-4">Payment</h1>
            
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Booking Details Section -->
                <div class="md:w-3/5">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <h2 class="text-lg font-semibold mb-4">Booking Details</h2>
                        
                        <div class="overflow-x-auto w-full">
                            <table class="w-full min-w-max">
                                <thead>
                                    <tr>
                                        <th class="text-left font-semibold px-6 py-3">Service</th>
                                        <th class="text-left font-semibold px-6 py-3">Date</th>
                                        <th class="text-left font-semibold px-6 py-3">Time</th>
                                        <th class="text-left font-semibold px-6 py-3">Location</th>
                                        <th class="text-left font-semibold px-6 py-3">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->services as $service)
                                        <tr>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <img class="h-12 w-12 mr-4" src="{{ asset('storage/images/' . $service->image) }}" alt="{{ $service->name . ' image'}}">
                                                    <span>{{ $service->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">{{ $service->pivot->date }}</td>
                                            <td class="py-4 px-6">
                                                {{ date('g:i a', strtotime($service->pivot->start_time)) }} - 
                                                {{ date('g:i a', strtotime($service->pivot->end_time)) }}
                                            </td>
                                            <td class="py-4 px-6">{{ App\Models\Location::find($service->pivot->location_id)->name }}</td>
                                            <td class="py-4 px-6">RM {{ number_format($service->pivot->price, 2, '.', ',') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Section -->
                <div class="md:w-2/5">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                        
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Total Amount:</span>
                                <span class="font-semibold text-lg">RM {{ number_format($cart->total, 2, '.', ',') }}</span>
                            </div>
                            <hr class="my-4">
                            
                            <div class="mb-4">
                                <h3 class="font-medium mb-2">Payment Instructions:</h3>
                                <p class="text-gray-600 mb-4">Please scan the QR code below to make your payment. After payment, upload your receipt to confirm your booking.</p>
                                
                                <div class="flex justify-center mb-4">
                                    <img src="{{ asset('storage/images/payment-qr.png') }}" alt="Payment QR Code" class="max-w-xs">
                                </div>
                            </div>
                            
                            <form action="{{ route('cart.process-payment') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">Upload Payment Receipt</label>
                                    <input type="file" id="receipt" name="receipt" accept="image/jpeg,image/png,image/jpg,application/pdf" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-pink-500 focus:border-pink-500" required>
                                    <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, JPEG, PNG, PDF</p>
                                    @error('receipt')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="w-full bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 transition duration-200">Confirm Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>