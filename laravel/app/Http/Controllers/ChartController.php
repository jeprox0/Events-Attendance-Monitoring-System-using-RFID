<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Event;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        // Get the event filter from the request
        $eventId = $request->input('event_id');

        // Fetch attendance data grouped by course_year_id for a specific event (if selected)
        $attendanceQuery = Attendance::with('student.courseYear')
            ->selectRaw('students.course_year_id, COUNT(attendances.id) as total_present')
            ->join('students', 'attendances.student_id', '=', 'students.id');

        if ($eventId) {
            $attendanceQuery->where('attendances.event_id', $eventId);
        }

        $attendanceData = $attendanceQuery->groupBy('students.course_year_id')->get();

        // Fetch all events for dropdown filter
        $events = Event::all();

        // Prepare data for the chart
        $labels = [];
        $data = [];

        foreach ($attendanceData as $record) {
            if ($record->student && $record->student->courseYear) {
                $labels[] = $record->student->courseYear->course_name . ' - ' . $record->student->courseYear->year_level;
                $data[] = $record->total_present;
            }
        }

        return view('attendance_chart', compact('labels', 'data', 'events'));
    }
}
