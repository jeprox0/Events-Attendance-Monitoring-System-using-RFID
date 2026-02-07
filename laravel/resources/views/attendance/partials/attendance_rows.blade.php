@forelse ($attendances as $attendance)
            <tr>
                <td>
                    @if($attendance->student->picture)
                        <img src="{{ asset('storage/' . $attendance->student->picture) }}" alt="Student Photo" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <p>No photo available</p>
                    @endif
                </td>
                <td>{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</td>
                <td>{{ $attendance->event->event_name }}</td>
                <td>{{ $attendance->created_at->format('g:i A') }}</td>
                <td>{{ $attendance->attendance_period }}</td>
                <td>
                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this attendance?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No attendances found for this event.</td>
            </tr>
        @endforelse