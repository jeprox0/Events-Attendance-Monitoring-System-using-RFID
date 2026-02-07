@include('themes.head');

<body>
    @include('themes.header');
    @include('themes.sidemenu');

    <main id="main" class="main">
        <!-- Border wrapper for the content -->
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1>Event List</h1>
                
                <!-- Button wrapper for aligning the button to the right -->
                <div>
                    <!-- Button to trigger the Add Event modal -->
                    <button type="button" class="cssbuttons-io-button" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                        </svg>
                        <span>Add</span>
                    </button>
                </div>
                
            </div><!-- End Page Title -->
            <br>
            
          

            <!-- Table wrapper with border -->
            <div style="border-top: 2px solid #ccc; padding-top: 20px;">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Semester</th>
                              <th>Name</th>
                                <th>Morning</th>
                                <th>Afternoon</th>
                                <th>Attendees</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td style="white-space: nowrap;">
                                        @if ($event->semester)
                                            {{ $event->semester->school_year }} - {{ $event->semester->semester }}
                                        @else
                                            No Semester Assigned
                                        @endif  
                                    </td>
                                    <td style="white-space: nowrap;">{{ $event->event_name }}</td>
<td style="white-space: nowrap;">
    @if($event->starttime_am && $event->endtime_am)
        {{ \Carbon\Carbon::parse($event->starttime_am)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->endtime_am)->format('g:i A') }}
    @else
        None
    @endif
</td>
<td style="white-space: nowrap;">
    @if($event->starttime_pm && $event->endtime_pm)
        {{ \Carbon\Carbon::parse($event->starttime_pm)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->endtime_pm)->format('g:i A') }}
    @else   
        None
    @endif
</td>
<td style="white-space: nowrap;">{{ ucfirst($event->attendees_type) }}</td>
<td style="white-space: nowrap;">{{ $event->start_date->format('Y-m-d') }}</td>


                                    <td>{{ $event->status }}</td>
                                    <td class="d-flex justify-content-start align-items-center">
                                        <!-- Edit Button with unique modal trigger -->
                                        
                                        <button type="button" class="Btn me-3" onclick="openEditModal({{ $event->id }}, '{{ $event->status }}')">
                                            Edit
                                            <svg class="svg" viewBox="0 0 512 512">
                                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- View Button -->
                                        <button type="button" class="btn btn-info me-3" data-bs-toggle="modal" data-bs-target="#showEventModal{{ $event->id }}">
                                            More
                                        </button>
                                        
                        
                                        <!-- Delete Form -->
                                        <form id="delete-form-{{ $event->id }}" action="{{ route('event.destroy', $event->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.9rem;" onclick="confirmDelete({{ $event->id }})">
                                            Delete
                                        </button>
                                        
                                        <script>
                                            function confirmDelete(id) {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: "You won't be able to revert this!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('delete-form-' + id).submit();
                                                    }
                                                });
                                            }
                                        </script>
                                        @if(session('success'))
                                        <script>
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: '{{ session('success') }}',
                                                timer: 3000, // Auto close after 3 seconds
                                                showConfirmButton: false
                                            });
                                        </script>
                                    @endif
                                    
                                    
                                    
                                    @if(session('error'))
                                        <script>
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: '{{ session('error') }}',
                                                timer: 3000,
                                                showConfirmButton: false
                                            });
                                        </script>
                                    @endif
                                    </td>
                                </tr>
                        
                                @include('event.edit')
                        
                                @include('event.show')
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- End of Table wrapper -->
                
            </div>

            <!-- Add Event Modal -->
           @include('event.create')
           
        </div> <!-- End of container wrapper -->
    </main><!-- End #main -->
<style>
    /* Ensure the table header, including the search box, is fixed at the top */
.dataTables_wrapper .dataTables_filter {
    position: sticky;
    top: 0;
    z-index: 100;
    background-color: #f9f9f9; /* Match the background color of your table */
    padding: 10px;
    border-bottom: 2px solid #ccc;
}

/* Optional: Add padding or shadow to the header for better visibility */
.dataTables_wrapper .dataTables_filter input {
    margin-left: 10px;
    padding: 5px;
    width: 200px; /* Adjust as necessary */
}

</style>
    <!-- Include necessary JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

    <script>
         function openEditModal(eventId, eventStatus) {
        if (eventStatus === 'completed') {
            alert('You cannot edit a completed event.');
        } else {
            // Open the edit modal for ongoing or upcoming events
            const modalId = `#editEventModal${eventId}`;
            const editModal = new bootstrap.Modal(document.querySelector(modalId));
            editModal.show();
        }
    }
    $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            fixedHeader: true
        });
    });
    </script>
</body>
</html>
@include('themes.footer');
