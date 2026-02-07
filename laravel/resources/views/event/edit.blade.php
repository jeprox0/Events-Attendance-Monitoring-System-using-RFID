<!-- Modal Structure -->
<div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="editEventModalLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('event.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Event Name, Description, and Date section (Full-width) -->
                    <div class="mb-3">
                        <label for="event_name" class="form-label fw-bold">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" value="{{ $event->event_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $event->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attendees_type" class="form-label">Attendees</label>
                        <select id="attendees_type" name="attendees_type" class="form-select" required>
                            <option value="">Select Attendees</option>
                            <option value="all" {{ $event->attendees_type == 'all' ? 'selected' : '' }}>All</option>
                            <option value="officers" {{ $event->attendees_type == 'officers' ? 'selected' : '' }}>Officers</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label fw-bold">Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date ? $event->start_date->format('Y-m-d') : '' }}" required>
                    </div>

                    <!-- Time Inputs (Aligned in rows for better structure) -->
                    <div class="row">
                        <!-- AM Times -->
                        <div class="col-md-6 border-end">
                            <h6 class="text-center fw-bold">Morning</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="starttime_am" class="form-label fw-bold">Start Time (AM)</label>
                                        <input type="time" class="form-control" id="starttime_am" name="starttime_am" value="{{ $event->starttime_am ? $event->starttime_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endtime_am" class="form-label fw-bold">End Time (AM)</label>
                                        <input type="time" class="form-control" id="endtime_am" name="endtime_am" value="{{ $event->endtime_am ? $event->endtime_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_start_am" class="form-label fw-bold">Time-in Start (AM)</label>
                                        <input type="time" class="form-control" id="timein_start_am" name="timein_start_am" value="{{ $event->timein_start_am ? $event->timein_start_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_end_am" class="form-label fw-bold">Time-in End (AM)</label>
                                        <input type="time" class="form-control" id="timein_end_am" name="timein_end_am" value="{{ $event->timein_end_am ? $event->timein_end_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_start_am" class="form-label fw-bold">Time-out Start (AM)</label>
                                        <input type="time" class="form-control" id="timeout_start_am" name="timeout_start_am" value="{{ $event->timeout_start_am ? $event->timeout_start_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_end_am" class="form-label fw-bold">Time-out End (AM)</label>
                                        <input type="time" class="form-control" id="timeout_end_am" name="timeout_end_am" value="{{ $event->timeout_end_am ? $event->timeout_end_am->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PM Times -->
                        <div class="col-md-6">
                            <h6 class="text-center fw-bold">Afternoon</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="starttime_pm" class="form-label fw-bold">Start Time (PM)</label>
                                        <input type="time" class="form-control" id="starttime_pm" name="starttime_pm" value="{{ $event->starttime_pm ? $event->starttime_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endtime_pm" class="form-label fw-bold">End Time (PM)</label>
                                        <input type="time" class="form-control" id="endtime_pm" name="endtime_pm" value="{{ $event->endtime_pm ? $event->endtime_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_start_pm" class="form-label fw-bold">Time-in Start (PM)</label>
                                        <input type="time" class="form-control" id="timein_start_pm" name="timein_start_pm" value="{{ $event->timein_start_pm ? $event->timein_start_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_end_pm" class="form-label fw-bold">Time-in End (PM)</label>
                                        <input type="time" class="form-control" id="timein_end_pm" name="timein_end_pm" value="{{ $event->timein_end_pm ? $event->timein_end_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_start_pm" class="form-label fw-bold">Time-out Start (PM)</label>
                                        <input type="time" class="form-control" id="timeout_start_pm" name="timeout_start_pm" value="{{ $event->timeout_start_pm ? $event->timeout_start_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_end_pm" class="form-label fw-bold">Time-out End (PM)</label>
                                        <input type="time" class="form-control" id="timeout_end_pm" name="timeout_end_pm" value="{{ $event->timeout_end_pm ? $event->timeout_end_pm->format('H:i') : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
