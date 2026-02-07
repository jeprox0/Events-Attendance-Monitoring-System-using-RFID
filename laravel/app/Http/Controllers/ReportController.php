<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Get all events
        $events = Event::all();

        // Prepare a list of students who are present per event
        $students = [];

        foreach ($events as $event) {
            $attendances = Attendance::where('event_id', $event->id)->get();
            $attendedStudentIds = $attendances->pluck('student_id')->toArray();

            // Get only students who are present
            $presentStudents = Student::whereIn('id', $attendedStudentIds)->with('courseYear')->get();

            foreach ($presentStudents as $student) {
                // Check attendance records for the student in this event
                $studentAttendance = $attendances->where('student_id', $student->id);
                $attendedPeriods = $studentAttendance->pluck('attendance_period')->toArray();

                // Determine attendance status
                $totalPeriods = ['timein_start_am', 'timein_end_am', 'timeout_start_am', 'timeout_end_am'];
                $attendedCount = count(array_intersect($totalPeriods, $attendedPeriods));

                if ($attendedCount === 4) {
                    $status = '✅ Present';
                } elseif ($attendedCount > 0) {
                    $status = '⚠️ Partially Absent';
                } else {
                    continue; // Skip students who are fully absent
                }

                // Get course & year
                $courseYear = $student->courseYear ? "{$student->courseYear->course_name} - {$student->courseYear->year_level}" : "N/A";

                $students[] = [
                    'student_name' => $student->first_name . ' ' . $student->last_name,
                    'course_year' => $courseYear,
                    'event_name' => $event->event_name,
                    'event_date' => $event->start_date,
                    'attendance_status' => $status,
                    'event_id' => $event->id
                ];
            }
        }

        return view('report', compact('students', 'events'));
    }
}
