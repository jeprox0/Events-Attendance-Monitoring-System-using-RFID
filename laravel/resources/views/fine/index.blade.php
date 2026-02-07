

@include('themes.head');

<body>
    @include('themes.header');
    @include('themes.sidemenu');
    <style>
        /* Modal Background and Padding */
        .modal-content {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    
        /* Header Styling */
        .modal-header {
            background-color: #007bff; /* Primary Color */
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
    
        /* Form Labels and Inputs */
        .form-label {
            color: #343a40;
            font-weight: bold;
        }
    
        .form-control {
            border: 2px solid #007bff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
    
        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
        }
    
        /* Picture Preview Styling */
        #picturePreview {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }
    
        /* Submit Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
    
        .btn-primary:hover {
            background-color: #0056b3;
        }
    
        /* Custom Styles for Modal */
        .modal-header .btn-close {
            background-color: white;
            border-radius: 50%;
            padding: 5px;
        }
    
        /* Error Message Styling */
        .error-message {
            color: red;
            display: none;
        }
    </style>
    
    <main id="main" class="main">
        <!-- Border wrapper for the content -->
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1>List of Absents</h1>
                
                <!-- Button wrapper for aligning the button to the right -->
                
                
            </div><!-- End Page Title -->
            <br>
            
            @session('success')
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endsession

            <!-- Table wrapper with border -->
            <div style="border-top: 2px solid #ccc; padding-top: 20px;">
                <form action="{{ route('fine.index') }}" method="GET" class="mb-3">
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
                        <th>Student Name</th>
                        
                        <th>Event</th>
                        <th>Total Fine (₱)</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                    <tbody>
                        @foreach($fines as $fine)
                        <tr>
                            <td>{{ ucfirst($fine->student->first_name) }} {{ ucfirst($fine->student->last_name) }}</td>
                        <td>{{ ucwords($fine->event->event_name) }}</td>
                        <td>{{ $fine->total_fine }}</td> <!-- Display total fine -->
                        <td>
                            <!-- Excuse Button (This button will open the modal) -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#excuseModal{{ $fine->id }}">
                                Excuse Absence
                            </button>
                        
                            <!-- Modal (Generated for each fine) -->
                            <div class="modal fade" id="excuseModal{{ $fine->id }}" tabindex="-1" aria-labelledby="excuseModalLabel{{ $fine->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="excuseModalLabel{{ $fine->id }}">Excuse Absence</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Excuse Form -->
                                            <form action="{{ route('fines.excuse') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $fine->student_id }}">
                                                <input type="hidden" name="event_id" value="{{ $fine->event_id }}">
                                            
                                                <div class="mb-3">
                                                    <label for="reason">Reason for Excuse:</label>
                                                    <textarea name="reason" class="form-control" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="picture">Upload Excuse Letter:</label>
                                                    <input type="file" name="picture" class="form-control" accept="image/*" >
                                                </div>
                                                <button type="submit" class="btn btn-success">Excuse</button>
                                            </form>
                                           
                                            
                                        
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        
                </table>
            </div><!-- End of Table wrapper -->


        </div> <!-- End of container wrapper -->
    </main><!-- End #main -->

    <!-- Include necessary JavaScript -->
   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
    
        <!-- Include Bootstrap JS and its dependencies -->
        
    <script>
        $('#example').DataTable({
                layout: {
                    
                }
            });
    </script>
    
</body>
</html>
@include('themes.footer');

