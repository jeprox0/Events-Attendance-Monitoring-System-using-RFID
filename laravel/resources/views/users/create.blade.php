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

 <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <form id="addStudentForm" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" style="font-weight: bold;">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" style="font-weight: bold;">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" style="font-weight: bold;">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" style="font-weight: bold;">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <!-- Error message for password mismatch -->
                    <div class="mb-3" id="passwordError" style="color: red; display: none;">
                        Passwords do not match.
                    </div>
                    <div class="mb-3">
                        <label for="role" style="font-weight: bold;">Role:</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin" selected>Admin</option>
                            <option value="super-admin" selected>Super Admin</option>
                            <!-- Option for user is removed for admin view -->
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('addStudentForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const passwordError = document.getElementById('passwordError');

        // Check if passwords match
        if (password !== confirmPassword) {
            event.preventDefault(); // Prevent form submission
            passwordError.style.display = 'block'; // Show the error message
            // Keep the modal open by stopping Bootstrap from closing it
            $('#addStudentModal').modal('show');
        } else {
            passwordError.style.display = 'none'; // Hide the error message if passwords match
        }
    });
    
$('#example').DataTable({
layout: {}
});

</script>