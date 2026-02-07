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

    /* Adjustments for Small Screens */
    @media screen and (max-width: 600px) {
        .modal-content {
            max-width: 85%;
            padding: 10px;
            margin: auto;
        }

        .form-label {
            font-size: 12px;
        }

        .form-control {
            font-size: 12px;
        }

        .btn-primary {
            font-size: 12px;
        }

        #picturePreview {
            width: 60px;
            height: 60px;
        }
    }
</style>

<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="studentForm" action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                <div id="emailError" class="error-message">Email already exists</div>
                            </div>
                            <div class="mb-3">
                                <label for="course_year_id" class="form-label">Course & Year</label>
                                <select name="course_year_id" id="course_year_id" class="form-control" required>
                                    <option value="">Select Course & Year</option>
                                    @foreach ($courseYears as $courseYear)
                                        <option value="{{ $courseYear->id }}">{{ $courseYear->course_name }} - {{ $courseYear->year_level }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="club_ids" class="form-label">Clubs</label>
                                <select name="club_ids[]" id="club_ids" class="form-control" multiple>
                                    @foreach ($clubs as $club)
                                        <option value="{{ $club->id }}">{{ $club->club_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="picture" class="form-label">Picture</label>
                                <input type="file" name="picture" accept="image/*" class="form-control">
                                <img id="picturePreview" src="#" alt="Picture Preview" class="img-fluid" style="max-height: 150px; display: none;">
                            </div>
                            <div class="mb-3">
                                <label for="rfid" class="form-label">ID</label>
                                <input type="text" name="rfid" id="rfid" class="form-control" readonly required>
                                <div id="rfidError" class="error-message">RFID is required</div>
                                <div id="rfidExistsError" class="error-message">RFID already exists</div>
                            </div>
                            <div class="mb-3">
                                <label for="semester_id" class="form-label">Semester</label>
                                <select name="semester_id" id="semester_id" class="form-control" required>
                                    <option value="">Choose Semester</option>
                                    @foreach($semesters as $semester)
                                        <option 
                                            value="{{ $semester->id }}" 
                                            @if($semester->status === 'Current') selected @else disabled @endif
                                        >
                                            {{ $semester->school_year }} | {{ $semester->semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  document.getElementById('studentForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Clear existing error messages
    document.getElementById('rfidError').style.display = 'none';
    document.getElementById('rfidExistsError').style.display = 'none';
    document.getElementById('emailError').style.display = 'none';

    // Validate RFID input is not empty
    var rfidInput = document.getElementById('rfid').value;
    if (!rfidInput || rfidInput.trim() === '') {
        document.getElementById('rfidError').style.display = 'block';
        return; // Stop the form submission
    }

    // Validate RFID existence
    validateRFID().then(function (isRFIDValid) {
        if (!isRFIDValid) return; // Stop if RFID is not valid

        // Validate Email
        validateEmail().then(function (isEmailValid) {
            if (isEmailValid) {
                event.target.submit(); // Submit the form if all validations pass
            }
        });
    });
});

// Fetch RFID button logic
function fetchRFID() {
    axios.get('http://localhost:5000/card')
        .then(function (response) {
            document.getElementById('rfid').value = response.data.uid;
        })
        .catch(function (error) {
            console.error(error);
            document.getElementById('rfid').value = ''; // Clear RFID field on error
        });
}

// Validate RFID via server-side API
function validateRFID() {
    var rfidInput = document.getElementById('rfid').value;
    return axios.post("{{ route('check.rfid') }}", { rfid: rfidInput })
        .then(function (response) {
            if (response.data.exists) {
                document.getElementById('rfidExistsError').style.display = 'block';
                return false;
            }
            return true;
        })
        .catch(function (error) {
            console.error(error);
            return true; // Allow submission on API failure
        });
}

// Validate Email via server-side API
function validateEmail() {
    var emailInput = document.getElementById('email').value;
    return axios.post("{{ route('check.email') }}", { email: emailInput })
        .then(function (response) {
            if (response.data.exists) {
                document.getElementById('emailError').style.display = 'block';
                return false;
            }
            return true;
        })
        .catch(function (error) {
            console.error(error);
            return true; // Allow submission on API failure
        });
}

// Image preview logic
document.querySelector('input[name="picture"]').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById('picturePreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});

</script>
