@foreach ($courses as $course)
    <!-- Modal for Editing Course -->
    <div class="modal fade" id="editStudentModal{{ $course->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px;"> <!-- Custom width for square form -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel{{ $course->id }}">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form action="{{ route('courses.update', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="course_name" style="font-weight: bold;">Course Name</label>
                            <input type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="year_level" style="font-weight: bold;">Year Level</label>
                            <input type="text" name="year_level" class="form-control" value="{{ $course->year_level }}" required>
                        </div>
                        <div class="modal-footer">
                           
                            <button type="submit" class="btn btn-primary">Update Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
