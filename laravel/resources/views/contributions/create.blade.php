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
  <div class="modal-dialog custom-modal"> <!-- Apply custom modal class -->
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addEventModalLabel">Add Contribution</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('contributions.store') }}" method="POST" onsubmit="clearUnusedFields()">
                @csrf
                <!-- Type Field -->
                <div class="mb-3">
                    <label for="type" class="form-label" style="font-weight: bold;">Type</label>
                    <input type="text" name="type" id="type" class="form-control" required>
                </div>
            
                <!-- Amount Field -->
                <div class="mb-3">
                    <label for="amount" class="form-label" style="font-weight: bold;">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="event_id" class="form-label" style="font-weight: bold;">( Optional ) Select Event</label>
                    <select name="event_id" id="event_id" class="form-control">
                        <option value="">Choose Event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Semester Selection Field -->
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
                <!-- Event Selection Field (Optional) -->
                
            
            
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
  /* Custom CSS for square modal */
.custom-modal {
    width: 400px; /* Set the width */
    height: 400px; /* Set the height to make it square */
    max-width: 100%;
}



</style>