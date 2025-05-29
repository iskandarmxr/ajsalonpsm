<!-- Add the success message here -->
@if(session('activate'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('activate') }}</span>
    </div>
@endif
@if(session('suspend'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('suspend') }}</span>
    </div>
@endif
@if(session('errormsg'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('errormsg') }}</span>
    </div>
@endif
<div class="flex justify-between mx-7 pt-4">
                <h2 class="text-2xl font-bold"></h2>
                <div class="flex items-center gap-4">
                    
                        <x-button wire:click="exportUsersToCSV" class="px-5 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                            <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                                <span>Export to CSV</span>
                            </div>
                        </x-button>

                        <x-button>
                            <a href="{{ route('users.create') }}" class="flex items-center gap-2">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </span>
                                <span>Add User</span>
                            </a>
                        </x-button>
                    
                </div>
            </div>
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-5">
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        
        <table id="usersTable" class="w-full border-collapse bg-white text-left text-sm text-gray-500 display responsive nowrap">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="pl-4 py-4 font-medium text-gray-900">ID</th>
                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">User</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Role</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">

                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="pl-6 py-2">{{ $user->id }}</td>

                        <th class="flex gap-3 px-6 py-2 font-normal text-gray-900">
                            <div class="relative h-10 w-10">
                                <img alt="{{ $user->name }}'s avatar}}"
                                    class="h-full w-full rounded-full object-cover object-center"
                                    src={{ $user->profile_photo_url }}
                      alt=""
                                />
                                {{-- <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span> --}}
                            </div>
                            <div class="text-sm">
                                <div class="font-medium text-gray-700">{{ $user->name}}</div>
                                <div class="text-gray-400">{{ $user->email}}</div>
                                <div class="text-gray-400 text-xs">{{ $user->phone_number}}</div>
                            </div>
                        </th>
                        <td class="px-6 py-2">
                            @if($user->status == true)
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
                                >
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600"
                                >
                                    Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-2">{{ $user->role()->first()->name }}</td>
                        <td class="px-6 py-2">
                            <div class="flex justify gap-4">
                                @if($user->status == true)
                                    <form action="{{ route('manageusers.suspend', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors" title="Suspend User">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('manageusers.activate', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors" title="Activate User">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>            
            <script>
                document.addEventListener('livewire:load', function() {
                    let table = $('#usersTable').DataTable({
                        responsive: true,
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "language": {
                            "search": "Search:",
                            "lengthMenu": "Show _MENU_ users per page",
                            "zeroRecords": "No matching users found",
                            "info": "Showing _START_ to _END_ of _TOTAL_ users",
                            "infoEmpty": "No users available",
                            "infoFiltered": "(filtered from _MAX_ total users)"
                        },
                        "columnDefs": [
                            { "orderable": false, "targets": 4 }
                        ],
                        "dom": '<"top"lf>rt<"bottom"ip><"clear">'
                    });

                    // Re-initialize DataTable when Livewire updates
                    Livewire.on('usersTable', () => {
                        table.destroy();
                        setTimeout(() => {
                            table = $('#usersTable').DataTable({
                                responsive: true,
                                "pageLength": 10,
                                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                "language": {
                                    "search": "Search:",
                                    "lengthMenu": "Show _MENU_ users per page",
                                    "zeroRecords": "No matching users found",
                                    "info": "Showing _START_ to _END_ of _TOTAL_ users",
                                    "infoEmpty": "No users available",
                                    "infoFiltered": "(filtered from _MAX_ total users)"
                                },
                                "columnDefs": [
                                    { "orderable": false, "targets": 4 }
                                ],
                                "dom": '<"top"lf>rt<"bottom"ip><"clear">'
                            });
                        }, 100);
                    });
                });
            </script>
            
            <style>
                /* Custom styling for DataTables */
                .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                    background: #ec4899 !important;
                    color: white !important;
                    border: 1px solid #ec4899 !important;
                }
                
                .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                    background: #f9a8d4 !important;
                    color: white !important;
                    border: 1px solid #f9a8d4 !important;
                }
                
                .dataTables_wrapper .dataTables_paginate .paginate_button {
                    border-radius: 0.375rem;
                    padding: 0.5rem 0.75rem;
                }
                
                .dataTables_wrapper .dataTables_filter,
                .dataTables_wrapper .dataTables_length {
                    margin-bottom: 1rem;
                    margin-top: 1rem;
                    padding: 0 1rem;
                }
            </style>
    </div>