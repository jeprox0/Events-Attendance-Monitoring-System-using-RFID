@if(isset($semesters) && $semesters->isNotEmpty())
    @foreach ($semesters as $semester)
        <!-- Modal for editing each semester -->
        <div class="modal fade" id="editUserModal{{ $semester->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit semester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Display validation errors -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('semesters.update', $semester->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="school_year">School Year</label>
                                <input type="text" class="form-control" name="school_year" id="school_year" value="{{ $semester->school_year }}" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <select class="form-control" name="semester" id="semester">
                                    <option value="First" {{ $semester->semester == 'First' ? 'selected' : '' }}>First</option>
                                    <option value="Second" {{ $semester->semester == 'Second' ? 'selected' : '' }}>Second</option>
                                </select>
                            </div>
                    
                            <button type="submit" class="btn btn-primary mt-3">Update Semester</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <!-- Display message if no semesters found -->
    <p>No semesters found.</p>
@endif
        
<!-- Script to handle dynamic club selection based on selected student -->




