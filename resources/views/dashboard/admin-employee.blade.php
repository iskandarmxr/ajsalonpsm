@php
    use App\Enums\UserRolesEnum;
    use App\Enums\AppointmentStatusEnum;
    $role = UserRolesEnum::from(Auth::user()->role_id)->name;
@endphp
<x-dashboard>

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-2 px-1 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold gap-4 p-2 text-center">Dashboard <span class="text-sm text-gray-500 ml-2">Overview</span></h2>
        </div>
    </header>

    <div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
            <!-- Total Customers -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $totalCustomers }}</p>
                    <p>Total Customers</p>
                </div>
            </div>

            <!-- Total Staffs -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $totalEmployees }}</p>
                    <p>Total Staffs</p>
                </div>
            </div>

            <!-- Total Services -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $totalServices }}</p>
                    <p>Total Hair Services</p>
                </div>
            </div>

            <!-- Total Location -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $totalLocations }}</p>
                    <p>Total Locations</p>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $pendingAppointments }}</p>
                    <p>Pending Appointments</p>
                </div>
            </div>

            <!-- Confirmed Appointments -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $confirmedAppointments }}</p>
                    <p>Confirmed Appointments</p>
                </div>
            </div>

            <!-- Completed Appointments -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $completedAppointments }}</p>
                    <p>Completed Appointments</p>
                </div>
            </div>

            <!-- Rejected Appointments -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $rejectedAppointments }}</p>
                    <p>Rejected Appointments</p>
                </div>
            </div>

            <!-- Cancelled Appointments -->
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-pink-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $cancelledAppointments }}</p>
                    <p>Cancelled Appointments</p>
                </div>
            </div>
        </div>

    <!-- Appointments Graph -->
    <div class="p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Appointments Overview</h3>
            <div class="w-full h-64">
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('appointmentsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Today', 'Tomorrow', 'Weekly', 'Monthly'],
                        datasets: [{
                            label: 'Number of Appointments',
                            data: [
                                {{ $todaysAppointments }},
                                {{ $tommorowsAppointments }},
                                {{ $weeklyAppointments }},
                                {{ $monthlyAppointments }}
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                                labels: {
                                    font: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </div>

<!-- Recent Appointments Table -->
<div class="p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Recent Appointments</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Code</th>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Service</th>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Location</th>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Date & Time Slot</th>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Customer Info</th>
                            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border-r border-gray-200">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAppointments as $appointment)
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->appointment_code }}</td>
                                <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->service->name }}</td>
                                <td class="px-4 py-4 border-r border-gray-200">{{ $appointment->location->name }}</td>
                                <td class="px-4 py-4 border-r border-gray-200">
                                    {{ $appointment->date }}<br>
                                    <span class="text-gray-500">{{ $appointment->timeSlot->start_time }} - {{ $appointment->timeSlot->end_time }}</span>
                                </td>
                                <td class="px-4 py-4 border-r border-gray-200">
                                    <div>{{ $appointment->user->name }}</div>
                                    <div class="text-gray-500">{{ $appointment->user->email }}</div>
                                </td>
                                <td class="px-4 py-4 border-r border-gray-200">
                                    <span class="px-3 py-1 text-sm rounded-full
                                        @if($appointment->status->value === 'pending') text-gray-800 bg-gray-50 @endif
                                        @if($appointment->status->value === 'confirmed') text-sky-800 bg-sky-50 @endif
                                        @if($appointment->status->value === 'completed') text-emerald-800 bg-emerald-50 @endif
                                        @if($appointment->status->value === 'rejected') text-orange-800 bg-orange-50 @endif
                                        @if($appointment->status->value === 'cancelled') text-rose-800 bg-rose-50 @endif">
                                        {{ ucfirst($appointment->status->value) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center">No Appointments Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="bg-pink-500 p-2 text-center">
        <span class="text-white">© Copyright 2025</span>
        <a
            class="font-semibold text-white hover:text-gray-200 transition"
            href="/admin/dashboard/"
        >
            AJ Hair Salon
        </a>
    </div>
</x-dashboard>
