@include('themes.head');

<body>
    @include('themes.header');
    @include('themes.sidemenu');

    <main id="main" class="main">
        <!-- Border wrapper for the content -->
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1>Attendance List</h1>
                
                <!-- Button wrapper for aligning the button to the right -->
                <div>   
                    <!-- Button to trigger the Add Student modal -->
                    <a href="{{ route('attendance.create') }}" class="cssbuttons-io-button" target="_blank">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                        </svg>
                        <span>Add</span>
                    </a>
                    
                </div>
                
            </div><!-- End Page Title -->
            <br>
            
           

            <!-- Table wrapper with border -->
            <div style="border-top: 2px solid #ccc; padding-top: 20px;">
                <form action="{{ route('attendance.index') }}" method="GET" class="mb-3">
                    <label for="event_filter">Filter by Event:</label>
                    <select name="event_id" id="event_filter" class="form-control" onchange="this.form.submit()">
                        <option value="">All Events</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->event_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th> Period</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr>
                                <td>
                                    @if($attendance->student->picture)
                                        <img src="{{ asset('storage/' . $attendance->student->picture) }}" alt="Student Photo" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <p>No photo available</p>
                                    @endif
                                </td>
                                <td>{{ ucfirst($attendance->student->first_name) }} {{ ucfirst($attendance->student->last_name) }}</td>
                                <td>{{ ucfirst($attendance->event->event_name) }}</td>
                                <td>{{ $attendance->created_at->format('F j, Y') }}</td> <!-- Date formatted as "Month Day, Year" -->
                                <td>{{ $attendance->created_at->format('g:i A') }}</td>
                                <td>{{ $attendance->attendance_period }}</td>
                                <td>
                                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this attendance?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <!-- No need for the 'No attendances found' message here; DataTables will handle it -->
                        @endforelse
                    </tbody>
                </table>
            </div><!-- End of Table wrapper -->

            <!-- Add Student Modal -->
          
        </div> <!-- End of container wrapper -->
    </main><!-- End #main -->

    <!-- Include necessary JavaScript -->
   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
    
        <!-- Include Bootstrap JS and its dependencies -->
        
        <script> 
            $(document).ready(function() {
                $('#example').DataTable({
                    "language": {
                        "emptyTable": "No attendances found for this event." // Custom message for empty table
                    },
                    "pageLength": 10, // You can adjust the number of entries per page
                    "order": [[1, 'asc']] // Optional: order the table by the second column (Name)
                });
            });
        </script>
        
    
</body>
</html>
@include('themes.footer');

