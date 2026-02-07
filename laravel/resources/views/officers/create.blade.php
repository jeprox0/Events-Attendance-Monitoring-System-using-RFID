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

<!-- Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Officer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('officers.store') }}" method="POST">
                    @csrf

                    <!-- Student selection -->
                    <div class="form-group">
                        <label for="student_id" style="font-weight: bold;">Student</label>
                        <select name="student_id" id="student_id" class="form-control" required>
                            <option value="">Select a Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ ucfirst($student->first_name) }} {{ ucfirst($student->last_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                  
                   <!-- Club selection -->
<div class="form-group mt-3">
    <label for="club_id" style="font-weight: bold;">Joined Clubs:</label>
    <select name="club_id" id="club_id" class="form-control" required>
        <option value="">Select a Club</option>
    </select>
</div>


                    <!-- Position name -->
                    <div class="form-group mt-3">
                        <label for="position_name" style="font-weight: bold;">Position</label>
                        <input type="text" name="position_name" id="position_name" class="form-control" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   // Update the club selection based on the student selection
document.getElementById('student_id').addEventListener('change', function() {
    // Get the selected student ID
    var selectedStudentId = this.value;

    // Clear the club selection
    var clubSelect = document.getElementById('club_id');
    clubSelect.innerHTML = '<option value="">Select a Club</option>'; // Reset club options

    // Check if a student is selected
    if (selectedStudentId) {
        // Find the clubs for the selected student
        var clubs = @json($students->toArray()); // Pass the students array from the backend to the frontend

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
    }
});

</script>
