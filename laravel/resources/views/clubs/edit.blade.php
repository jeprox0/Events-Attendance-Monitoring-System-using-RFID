@foreach ($clubs as $club)
    <!-- Modal for Editing club -->
    <div class="modal fade" id="editStudentModal{{ $club->id }}" tabindex="-1" aria-labelledby="editStudentModalLabel{{ $club->id }}" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px;"> <!-- Custom width for square form -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel{{ $club->id }}">Edit Club</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form action="{{ route('clubs.update', $club->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="club_name">Club Name</label>
                            <input type="text" name="club_name" class="form-control" value="{{ $club->club_name }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update Club</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
