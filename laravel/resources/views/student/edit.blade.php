@foreach($students as $student)
    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
        <div class="modal-dialog modal-md"> <!-- Kept the modal size as modal-md -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel{{ $student->id }}">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name{{ $student->id }}" style="font-weight: bold;">Firstname</label>
                                    <input type="text" name="first_name" id="first_name{{ $student->id }}" class="form-control" value="{{ $student->first_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name{{ $student->id }}" style="font-weight: bold;">Lastname</label>
                                    <input type="text" name="last_name" id="last_name{{ $student->id }}" class="form-control" value="{{ $student->last_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email{{ $student->id }}" style="font-weight: bold;">Email</label>
                                    <input type="email" name="email" id="email{{ $student->id }}" class="form-control" value="{{ $student->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="course_year_id{{ $student->id }}" style="font-weight: bold;">Course & Year</label>
                                    <select name="course_year_id" id="course_year_id{{ $student->id }}" class="form-control" >
                                        <option value="">Select Course & Year</option>
                                        @foreach ($courseYears as $courseYear)
                                            <option value="{{ $courseYear->id }}" {{ $student->course_year_id == $courseYear->id ? 'selected' : '' }}>
                                                {{ $courseYear->course_name }} - {{ $courseYear->year_level }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="clubs{{ $student->id }}" style="font-weight: bold;">Clubs</label>
                                    <select name="clubs[]" id="clubs{{ $student->id }}" class="form-control" multiple> <!-- Enable multi-select -->
                                        @foreach ($clubs as $club)
                                            <option value="{{ $club->id }}" 
                                                @if($student->clubs->contains($club->id)) selected @endif>
                                                {{ $club->club_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="picture{{ $student->id }}">Picture:</label>
                                    @if($student->picture)
                                        <img src="{{ asset('storage/' . $student->picture) }}" alt="Student Picture" width="100" height="100">
                                    @else
                                        <span>No picture uploaded</span>
                                    @endif
                                    <input type="file" name="picture" accept="image/*" class="form-control mt-2">
                                </div>
                                <div class="mb-3">
                                    <label for="rfid{{ $student->id }}" style="font-weight: bold;">RFID UID:</label>
                                    <input type="text" name="rfid" id="rfid{{ $student->id }}" class="form-control" value="{{ $student->rfid }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
