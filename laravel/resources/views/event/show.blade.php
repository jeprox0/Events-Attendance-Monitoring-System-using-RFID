<!-- Show Event Modal Structure -->
<div class="modal fade" id="showEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="showEventModalLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showEventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Event Name, Description, and Date section -->
                
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" readonly>{{ $event->description }}</textarea>
                    </div>


                    <!-- Time Inputs -->
                    <div class="row">
                        <!-- AM Times -->
                        <div class="col-md-6 border-end">
                            <h6 class="text-center fw-bold">Morning</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="starttime_am" class="form-label fw-bold">Start Time (AM)</label>
                                        <input type="time" class="form-control" id="starttime_am" name="starttime_am" value="{{ $event->starttime_am ? $event->starttime_am->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endtime_am" class="form-label fw-bold">End Time (AM)</label>
                                        <input type="time" class="form-control" id="endtime_am" name="endtime_am" value="{{ $event->endtime_am ? $event->endtime_am->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_start_am" class="form-label fw-bold">Time-in Start (AM)</label>
                                        <input type="time" class="form-control" id="timein_start_am" name="timein_start_am" value="{{ $event->timein_start_am ? $event->timein_start_am->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_end_am" class="form-label fw-bold">Time-in End (AM)</label>
                                        <input type="time" class="form-control" id="timein_end_am" name="timein_end_am" value="{{ $event->timein_end_am ? $event->timein_end_am->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_start_am" class="form-label fw-bold">Time-out Start (AM)</label>
                                        <input type="time" class="form-control" id="timeout_start_am" name="timeout_start_am" value="{{ $event->timeout_start_am ? $event->timeout_start_am->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_end_am" class="form-label fw-bold">Time-out End (AM)</label>
                                        <input type="time" class="form-control" id="timeout_end_am" name="timeout_end_am" value="{{ $event->timeout_end_am ? $event->timeout_end_am->format('H:i') : '' }}" readonly>
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
                                        <input type="time" class="form-control" id="starttime_pm" name="starttime_pm" value="{{ $event->starttime_pm ? $event->starttime_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endtime_pm" class="form-label fw-bold">End Time (PM)</label>
                                        <input type="time" class="form-control" id="endtime_pm" name="endtime_pm" value="{{ $event->endtime_pm ? $event->endtime_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_start_pm" class="form-label fw-bold">Time-in Start (PM)</label>
                                        <input type="time" class="form-control" id="timein_start_pm" name="timein_start_pm" value="{{ $event->timein_start_pm ? $event->timein_start_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timein_end_pm" class="form-label fw-bold">Time-in End (PM)</label>
                                        <input type="time" class="form-control" id="timein_end_pm" name="timein_end_pm" value="{{ $event->timein_end_pm ? $event->timein_end_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_start_pm" class="form-label fw-bold">Time-out Start (PM)</label>
                                        <input type="time" class="form-control" id="timeout_start_pm" name="timeout_start_pm" value="{{ $event->timeout_start_pm ? $event->timeout_start_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout_end_pm" class="form-label fw-bold">Time-out End (PM)</label>
                                        <input type="time" class="form-control" id="timeout_end_pm" name="timeout_end_pm" value="{{ $event->timeout_end_pm ? $event->timeout_end_pm->format('H:i') : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
