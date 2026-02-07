@if(isset($officers) && $officers->isNotEmpty())
    @foreach ($officers as $officer)
        <!-- Modal for editing each officer -->
        <div class="modal fade" id="editUserModal{{ $officer->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit Officer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Display validation errors -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Form for editing the officer -->
                        <form action="{{ route('officers.update', $officer->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Student selection -->
                            <div class="form-group">
                                <label for="student_id">Student</label>
                                <select name="student_id" id="student_id{{ $officer->id }}" class="form-control" required>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $officer->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Club selection -->
                            <div class="form-group mt-3">
                                <label for="club_id">Club</label>
                                <select name="club_id" id="club_id{{ $officer->id }}" class="form-control" required>
                                    <option value="">Select a Club</option>
                                    @foreach($officer->student->clubs as $club)
                                    <option value="{{ $club->id }}" {{ $officer->club_id == $club->id ? 'selected' : '' }}>
                                        {{ $club->club_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Position name input -->
                            <div class="form-group mt-3">
                                <label for="position_name">Position Name</label>
                                <input type="text" name="position_name" id="position_name" class="form-control" value="{{ old('position_name', $officer->position_name) }}" required>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <!-- Display message if no officers found -->
    <p>No officers found.</p>
@endif
        
<!-- Script to handle dynamic club selection based on selected student -->

   <script>
    document.querySelectorAll('select[id^="student_id"]').forEach(function(select) {
        select.addEventListener('change', function() {
            var selectedStudentId = this.value;
            var officerId = this.id.replace('student_id', ''); // Extract officer id
            var clubSelect = document.getElementById('club_id' + officerId);
            clubSelect.innerHTML = '<option value="">Select a Club</option>'; // Reset club options

            // Check if a student is selected
            if (selectedStudentId) {
                var clubs = @json($students->toArray()); // Pass the students array from the backend to the frontend

                // Find the student based on selectedStudentId
                var selectedOfficer = @json($officers).find(officer => officer.id == officerId);

                // Populate the club options based on the selected student
                clubs.forEach(function(student) {
                    if (student.id == selectedStudentId) {
                        student.clubs.forEach(function(club) {
                            var option = document.createElement('option');
                            option.value = club.id;
                            option.textContent = club.club_name;
                            clubSelect.appendChild(option);
                        });
                    }
                });

                // Set the previously selected club (if any)
                if (selectedOfficer && selectedOfficer.club_id) {
                    clubSelect.value = selectedOfficer.club_id; // Set the selected value in the dropdown
                }
            }
        });

        // Trigger change event to initialize the club selection when the modal opens
        select.dispatchEvent(new Event('change'));
    });
</script>


