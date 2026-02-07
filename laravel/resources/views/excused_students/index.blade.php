@include('themes.head')

<body>
    @include('themes.header')
    @include('themes.sidemenu')

    <main id="main" class="main">
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1> List of Excused </h1>
            </div>
            <br>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div style="border-top: 2px solid #ccc; padding-top: 20px;">
                <form action="{{ route('excused_students.index') }}" method="GET" class="mb-3">
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
                            <th>Event Name</th>
                            <th>Reason</th>
                            <th>Excuse Letter</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($excusedStudents as $excuse)
    <tr>
        <td class="no-wrap">{{ ucfirst($excuse->student->first_name) }} {{ ucfirst($excuse->student->last_name) }}</td>
            <td>{{ $excuse->event->event_name }}</td>
            <td>{{ ucfirst($excuse->reason) ?? 'No reason provided' }}</td>
            <td>
                @if($excuse->picture)
                    <!-- Modal Trigger Button -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewPictureModal-{{ $excuse->id }}">
                        View
                    </button>
                @else
                    <p>No letter submitted</p>
                @endif
            </td>
        <td>
            <div class="d-flex justify-content-start align-items-center">
                <button type="button" class="Btn me-3" data-bs-toggle="modal" data-bs-target="#editContributionModal{{ $excuse->id }}">
                    Edit 
                    <!-- SVG icon here -->
                </button>

                <form action="{{ route('excused_students.destroy', $excuse->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-custom" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                </form>
            </div>
        </td>
    </tr>

   <!-- Modal Structure for Each Excuse -->
   <div class="modal fade" id="viewPictureModal-{{ $excuse->id }}" tabindex="-1" aria-labelledby="viewPictureModalLabel-{{ $excuse->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPictureModalLabel-{{ $excuse->id }}">Excuse Letter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display the image -->
                @if($excuse->picture)
    <img src="{{ asset('uploads/excuses/' . $excuse->picture) }}" alt="Excuse Letter" class="img-fluid">
@else
    <p>No picture uploaded.</p>
@endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@empty
<tr>
    <td colspan="5">No excused students found.</td>
</tr>
@endforelse

                    </tbody>
                </table>
        
            </div><!-- End of Table wrapper -->
        </div> <!-- End of container wrapper -->
    </main><!-- End #main -->

    <!-- Edit Contribution Modal -->
    @foreach ($excusedStudents as $excuse)
        <div class="modal fade" id="editContributionModal{{ $excuse->id }}" tabindex="-1" aria-labelledby="editContributionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editContributionModalLabel">Edit Excused Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('excused_students.update', $excuse->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="student_name" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="student_name" name="student_name" value="{{ ucfirst($excuse->student->first_name) }} {{ ucfirst($excuse->student->last_name) }}" readonly>
                            </div>
                          
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3">{{ ucfirst($excuse->reason) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="excuse_letter" class="form-label">Excuse Letter (optional)</label>
                                <input type="file" class="form-control" id="excuse_letter" name="excuse_letter">
                            
                                @if($excuse->picture)
                                    <div class="mt-2">
                                        <label>Current letter:</label>
                                        <img src="{{ asset('uploads/excuses/' . $excuse->picture) }}" alt="Excuse Letter" style="max-width: 100%; height: auto; display: block; margin-top: 10px;">
                                    </div>
                                @endif
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
<style>
    .btn-custom {
    padding: 0.33rem 0.5rem; /* Adjust padding for smaller buttons */
    font-size: 0.875rem; /* Smaller font size */
}

</style>
    <!-- Include necessary JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Check if there are any excused students
            @if($excusedStudents->isNotEmpty())
                $('#example').DataTable(); // Initialize DataTable if there are excused students
            @endif
        });
    </script>
</body>
@include('themes.footer')