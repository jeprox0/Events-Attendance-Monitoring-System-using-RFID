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


<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="{{ route('payments.store') }}" method="POST" onsubmit="return validateAmount()">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="student_id" class="col-sm-3 col-form-label" style="font-weight: bold;">Student</label>
                        <div class="col-sm-9">
                            <select name="student_id" id="student_id" class="form-control select2" style="width: 100%;" required onchange="fetchBalance()">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ ucfirst($student->first_name) }} {{ ucfirst($student->last_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="balance" class="col-sm-3 col-form-label" style="font-weight: bold;">Total Balance</label>
                        <div class="col-sm-9">
                            <input type="text" name="balance" id="balance" class="form-control" readonly style="width: 100%;">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="amount_paid" class="col-sm-3 col-form-label" style="font-weight: bold;">Amount Paid</label>
                        <div class="col-sm-9">
                            <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" required style="width: 100%;">
                            <small id="error-msg" style="color: red; display: none;">Amount cannot be greater than the balance.</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="semester_id" class="col-sm-3 col-form-label" style="font-weight: bold;">Semester</label>
                        <div class="col-sm-9">
                            <select name="semester_id" id="semester_id" class="form-control" required style="width: 100%;" onchange="resetBalance()">
                                <option value="">Semester</option>
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
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </div>
                </form>
                
                
                
            </div>
        </div>
    </div>
</div>

<style>
    .select2-results__options {
        max-height: 150px; /* Limit to 5 options (30px per option approx.) */
        overflow-y: auto;  /* Enable vertical scrolling */
    }
    .select2 {
    width: 100% !important; /* Force the width to be 100% */
    min-width: 300px; /* Set a minimum width */
}

    /* Adjust modal width to be smaller */
    .custom-modal-width {
        max-width: 500px; /* Set to a smaller width */
    }

    /* Make the select2 input smaller */
    .select2-container {
        width: 100% !important; /* Ensure select2 takes up full available space */
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2 with a placeholder and search input
        $('#student_id').select2({
            placeholder: 'Select Student',
            allowClear: true,
            dropdownParent: $('#addEventModal'), // Ensures modal compatibility
            width: '100%'  // Ensures the dropdown is full width
        });

        // Add placeholder inside the search box
        $('#student_id').on('select2:open', function() {
            let select2SearchField = $('.select2-search__field');
            select2SearchField.attr('placeholder', 'Search');  // Add placeholder
        });
    });

    // Fetch balance based on the selected student
    function fetchBalance() {
    const studentId = document.getElementById('student_id').value;
    const semesterId = document.getElementById('semester_id').value;

    if (studentId && semesterId) {
        fetch(`/payments/balance/${studentId}/${semesterId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('balance').value = data.balance.toFixed(2); // Set balance in number format
            })
            .catch(error => console.error('Error fetching balance:', error));
    } else {
        document.getElementById('balance').value = '';
    }
}

function resetBalance() {
    document.getElementById('balance').value = '';
}


    // Validate the amount paid against the balance
    function validateAmount() {
        const balance = parseFloat(document.getElementById('balance').value); // Parse balance as number
        const amountPaid = parseFloat(document.getElementById('amount_paid').value); // Parse amount paid as number
        const errorMsg = document.getElementById('error-msg');
        
        if (amountPaid > balance) {
            errorMsg.style.display = 'block'; // Show error message
            return false; // Prevent form submission
        }

        errorMsg.style.display = 'none'; // Hide error message if no error
        return true; // Allow form submission
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery (if not already included) -->


<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <!-- Include Bootstrap JS and its dependencies -->
    
    
</body>

