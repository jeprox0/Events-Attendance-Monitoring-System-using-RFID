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
<!-- Modal Structure -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('event.store') }}" method="POST" onsubmit="return clearUnusedFields()">
                    @csrf
                    
                    <!-- Event Name -->
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" name="event_name" id="event_name" class="form-control" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">( Optional ) Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>

                    <!-- Attendees Dropdown -->
                    <div class="mb-3">
                        <label for="attendees_type" class="form-label">Attendees</label>
                        <select id="attendees_type" name="attendees_type" class="form-select" required>
                            <option value="">Select Attendees</option>
                            <option value="all">All Student</option>
                            <option value="officers">Only Officers</option>
                        </select>
                    </div>

                    <!-- Schedule Dropdown -->
                    <div class="mb-3">
                        <label for="halfday_select" class="form-label">Select Schedule</label>
                        <select id="halfday_select" name="halfday_option" class="form-select" onchange="toggleTimeInputs()">
                            <option value="">Select</option>
                            <option value="wholeday">Whole day</option>
                            <option value="morning">Morning</option>
                            <option value="afternoon">Afternoon</option>
                        </select>
                    </div>

                    <!-- Time Inputs (Morning and Afternoon) -->
                    <div id="time_inputs" class="hidden"> <!-- Hide by default -->
                        <!-- Morning Times -->
                        <div id="morning_times">
                            <h6>Morning</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="starttime_am" class="form-label">Start Time AM</label>
                                    <input type="time" name="starttime_am" id="starttime_am" class="form-control" value="07:30">
                                </div>
                                <div class="col-md-6">
                                    <label for="endtime_am" class="form-label">End Time AM</label>
                                    <input type="time" name="endtime_am" id="endtime_am" class="form-control" value="12:00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="timein_start_am" class="form-label">Time In Start AM</label>
                                    <input type="time" name="timein_start_am" id="timein_start_am" class="form-control" value="08:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="timein_end_am" class="form-label">Time In End AM</label>
                                    <input type="time" name="timein_end_am" id="timein_end_am" class="form-control" value="09:00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="timeout_start_am" class="form-label">Time Out Start AM</label>
                                    <input type="time" name="timeout_start_am" id="timeout_start_am" class="form-control" value="11:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="timeout_end_am" class="form-label">Time Out End AM</label>
                                    <input type="time" name="timeout_end_am" id="timeout_end_am" class="form-control" value="11:50">
                                </div>
                            </div>
                        </div>

                        <!-- Afternoon Times -->
                        <div id="afternoon_times">
                            <h6>Afternoon</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="starttime_pm" class="form-label">Start Time PM</label>
                                    <input type="time" name="starttime_pm" id="starttime_pm" class="form-control" value="13:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="endtime_pm" class="form-label">End Time PM</label>
                                    <input type="time" name="endtime_pm" id="endtime_pm" class="form-control" value="17:00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="timein_start_pm" class="form-label">Time In Start PM</label>
                                    <input type="time" name="timein_start_pm" id="timein_start_pm" class="form-control" value="13:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="timein_end_pm" class="form-label">Time In End PM</label>
                                    <input type="time" name="timein_end_pm" id="timein_end_pm" class="form-control" value="14:00">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="timeout_start_pm" class="form-label">Time Out Start PM</label>
                                    <input type="time" name="timeout_start_pm" id="timeout_start_pm" class="form-control" value="15:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="timeout_end_pm" class="form-label">Time Out End PM</label>
                                    <input type="time" name="timeout_end_pm" id="timeout_end_pm" class="form-control" value="16:30">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="semester_id" class="form-label" style="font-weight: bold;">Select Semester</label>
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
                    <!-- Submit Button -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .hidden {
        display: none;
    }
</style>

<script>
    function toggleTimeInputs() {
        const selectedOption = document.getElementById('halfday_select').value;
        const timeInputs = document.getElementById('time_inputs');

        // Show or hide time inputs based on selection
        timeInputs.classList.toggle('hidden', !selectedOption);
        
        // Show or hide morning and afternoon times
        const morningTimes = document.getElementById('morning_times');
        const afternoonTimes = document.getElementById('afternoon_times');

        morningTimes.classList.toggle('hidden', !(selectedOption === 'morning' || selectedOption === 'wholeday'));
        afternoonTimes.classList.toggle('hidden', !(selectedOption === 'afternoon' || selectedOption === 'wholeday'));
    }

    function clearUnusedFields() {
        const selectedOption = document.getElementById('halfday_select').value;

        // Clear fields based on selection
        if (selectedOption === 'morning') {
            clearAfternoonFields();
        } else if (selectedOption === 'afternoon') {
            clearMorningFields();
        } else if (selectedOption === 'wholeday') {
            clearMorningFields();
            clearAfternoonFields();
        }

        // Prevent form submission if no schedule is selected
        if (!selectedOption) {
            alert("Please select a schedule option.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

    function clearMorningFields() {
        const morningFields = ['starttime_am', 'endtime_am', 'timein_start_am', 'timein_end_am', 'timeout_start_am', 'timeout_end_am'];
        morningFields.forEach(field => document.getElementById(field).value = '');
    }

    function clearAfternoonFields() {
        const afternoonFields = ['starttime_pm', 'endtime_pm', 'timein_start_pm', 'timein_end_pm', 'timeout_start_pm', 'timeout_end_pm'];
        afternoonFields.forEach(field => document.getElementById(field).value = '');
    }
</script>
 