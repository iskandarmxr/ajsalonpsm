<x-dashboard>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center">Appointments Calendar</h2>
        </div>
    </header>

    <div class="p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">{{ $view === 'week' ? 'Weekly' : 'Monthly' }} Schedule
                @if($view === 'month')
                        ({{ $startOfMonth->format('F Y') }})
                    @endif
                </h3>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 {{ $view === 'month' ? 'bg-pink-600' : 'bg-gray-600' }} text-white rounded-md" onclick="switchView('month')">
                        month
                    </button>
                    <button class="px-4 py-2 {{ $view === 'week' ? 'bg-pink-600' : 'bg-gray-600' }} text-white rounded-md" onclick="switchView('week')">
                        week
                    </button>
                    <button class="px-2 py-2 bg-gray-600 text-white rounded-md" onclick="navigate('prev')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-2 py-2 bg-gray-600 text-white rounded-md" onclick="navigate('next')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if($view === 'week')
                    <!-- Weekly View -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                @for($i = 0; $i < 7; $i++)
                                    @php
                                        $date = $startOfWeek->copy()->addDays($i);
                                        $isToday = $date->isToday();
                                    @endphp
                                    <th class="px-2 py-3 border {{ $isToday ? 'bg-blue-50' : 'bg-gray-50' }}">
                                        <div class="text-sm">{{ $date->format('D') }}</div>
                                        <div class="font-normal">{{ $date->format('j/n') }}</div>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for($hour = 8; $hour < 20; $hour++)
                                <tr>
                                    @for($i = 0; $i < 7; $i++)
                                        @php
                                            $date = $startOfWeek->copy()->addDays($i);
                                            $dateStr = $date->format('Y-m-d');
                                            $cellId = "cell-$dateStr-$hour";
                                        @endphp
                                        <td id="{{ $cellId }}" class="px-2 py-1 border align-top relative time-cell" style="height: 60px;">
                                            @if(isset($appointments[$dateStr]))
                                                @foreach($appointments[$dateStr] as $appointment)
                                                    @php
                                                        $appointmentHour = (int)substr($appointment->timeSlot->start_time, 0, 2);
                                                    @endphp
                                                    @if($appointmentHour === $hour)
                                                        <div class="appointment-card text-xs p-1 mb-1 rounded bg-pink-100 text-pink-800">
                                                            <span class="font-medium">{{ $appointment->user->name }}</span>
                                                            <br>
                                                            {{ $appointment->service->name }}
                                                            <br>
                                                            {{ $appointment->timeSlot->start_time }}
                                                            - {{ $appointment->timeSlot->end_time }}
                                                            <br>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                @else
                    <!-- Monthly View -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 border bg-gray-50">Sun</th>
                                <th class="px-2 py-3 border bg-gray-50">Mon</th>
                                <th class="px-2 py-3 border bg-gray-50">Tue</th>
                                <th class="px-2 py-3 border bg-gray-50">Wed</th>
                                <th class="px-2 py-3 border bg-gray-50">Thu</th>
                                <th class="px-2 py-3 border bg-gray-50">Fri</th>
                                <th class="px-2 py-3 border bg-gray-50">Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentDate = $startOfMonth->copy()->startOfWeek();
                                $endDate = $endOfMonth->copy()->endOfWeek();
                            @endphp
                            @while($currentDate <= $endDate)
                                <tr>
                                    @for($i = 0; $i < 7; $i++)
                                        @php
                                            $isCurrentMonth = $currentDate->month === $startOfMonth->month;
                                            $isToday = $currentDate->isToday();
                                            $dateStr = $currentDate->format('Y-m-d');
                                        @endphp
                                        <td class="px-2 py-1 border align-top relative {{ $isCurrentMonth ? '' : 'bg-gray-100' }} {{ $isToday ? 'bg-blue-50' : '' }}" style="height: 100px;">
                                            <div class="text-sm {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }}">
                                                {{ $currentDate->format('j') }}
                                            </div>
                                            @if(isset($appointments[$dateStr]))
                                                @foreach($appointments[$dateStr] as $appointment)
                                                    <div class="appointment-card text-xs p-1 mb-1 rounded bg-pink-100 text-pink-800">
                                                        <span class="font-medium">{{ $appointment->user->name }}</span>
                                                        <br>
                                                        {{ $appointment->service->name }}
                                                        <br>
                                                        {{ $appointment->timeSlot->start_time }}
                                                        - {{ $appointment->timeSlot->end_time }}
                                                        <br>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        @php
                                            $currentDate->addDay();
                                        @endphp
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
        <!--Copyright section-->
        <div class="bg-pink-500 p-2 text-center">
            <span class="text-white">© Copyright 2025</span>
            <a
                class="font-semibold text-white hover:text-gray-200 transition"
                href="/admin/dashboard/"
            >
                AJ Hair Salon
            </a>
        </div>

    <script>
        function navigate(direction) {
            const currentUrl = new URL(window.location.href);
            const searchParams = currentUrl.searchParams;
            const view = searchParams.get('view') || 'month';
            
            let date = searchParams.get('date') ? new Date(searchParams.get('date')) : new Date();
            
            if (view === 'week') {
                if (direction === 'prev') {
                    date.setDate(date.getDate() - 7);
                } else {
                    date.setDate(date.getDate() + 7);
                }
            } else {
                if (direction === 'prev') {
                    date.setMonth(date.getMonth() - 1);
                } else {
                    date.setMonth(date.getMonth() + 1);
                }
            }
            
            const formattedDate = date.toISOString().split('T')[0];
            window.location.href = `${currentUrl.pathname}?date=${formattedDate}&view=${view}`;
        }

        function switchView(newView) {
            const currentUrl = new URL(window.location.href);
            const searchParams = currentUrl.searchParams;
            const date = searchParams.get('date') || new Date().toISOString().split('T')[0];
            
            window.location.href = `${currentUrl.pathname}?date=${date}&view=${newView}`;
        }
    </script>

    <style>
        .time-cell {
            position: relative;
            overflow: visible;
            min-width: 100px;
        }
        
        .appointment-card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            width: calc(100% - 4px);
            overflow: hidden;
        }
        
        .appointment-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 20;
        }
    </style>
</x-dashboard>