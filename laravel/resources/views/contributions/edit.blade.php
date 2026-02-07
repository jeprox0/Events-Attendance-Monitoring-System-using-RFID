<!-- Modal for editing each contribution -->
@foreach($contributions as $contribution)
<div class="modal fade" id="editContributionModal{{ $contribution->id }}" tabindex="-1" aria-labelledby="editContributionModalLabel{{ $contribution->id }}" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContributionModalLabel{{ $contribution->id }}">Edit Contribution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form -->
                <form action="{{ route('contributions.update', $contribution->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="type{{ $contribution->id }}" class="form-label">Type</label>
                        <input type="text" name="type" id="type{{ $contribution->id }}" class="form-control" value="{{ old('type', $contribution->type) }}">
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    </div>

                    
                    <div class="mb-3">
                        <label for="amount{{ $contribution->id }}" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount{{ $contribution->id }}" class="form-control" step="0.01" value="{{ old('amount', $contribution->amount) }}">
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    </div>
                    <div class="mb-3">
                        <label for="event_id{{ $contribution->id }}" class="form-label">Event</label>
                        <select name="event_id" id="event_id{{ $contribution->id }}" class="form-select">
                            <option value="">None</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ $contribution->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->event_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
    <div class="text-danger">{{ $message }}</div>
@enderror

                    </div>

                    

                    <div class="mb-3">
                        <label for="semester_id" class="form-label" style="font-weight: bold;">Selected Semester</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $semesters->firstWhere('id', $contribution->semester_id)->school_year }} - {{ $semesters->firstWhere('id', $contribution->semester_id)->semester }}" 
                            readonly
                        >
                        <input type="hidden" name="semester_id" value="{{ $contribution->semester_id }}">
                    </div>
                    

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Contribution</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach