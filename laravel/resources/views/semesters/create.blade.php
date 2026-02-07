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
                <h5 class="modal-title" id="addStudentModalLabel">Create Semester</h5>
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

                <form action="{{ route('semesters.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="school_year">School Year</label>
                        <input type="text" class="form-control" name="school_year" id="school_year" required>
                    </div>
            
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester">
                            <option value="First">First</option>
                            <option value="Second">Second</option>
                        </select>
                    </div>
            
                    <button type="submit" class="btn btn-primary mt-3">Save Semester</button>
                </form>
            </div>
        </div>
    </div>
</div>

