<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Officer;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
        public function index(Request $request)
        {
            // Get the event filter if applied
            $attendances = Attendance::with(['student', 'event'])
                ->when($request->event_id, function($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                })
                ->paginate(10); // Paginate with 10 results per page
        
            // If it's an AJAX request, only return the table rows
        
        
            $events = Event::all(); // Get all events for the dropdown filter
            return view('attendance.index', compact('attendances', 'events'));
        }
    
    



    public function create()
    {
        // Retrieve all events for the dropdown in the create attendance form
        $events = Event::all();

        return view('attendance.create', compact('events'));
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'rfid' => 'required|string',
        'event_id' => 'required|exists:events,id',
        'attendance_period' => 'required|string',
    ]);

    // Find the student by RFID
    $student = Student::where('rfid', $request->rfid)->first();

    if (!$student) {
        return redirect()->back()->with('error', 'Student not found');
    }

    // Get the event and its time periods
    $event = Event::find($request->event_id);
    $currentTime = Carbon::now();

    // Determine the attendance period
    switch ($request->attendance_period) {
        case 'Time-in (AM)':
            $startTime = Carbon::parse($event->start_date . ' ' . $event->timein_start_am);
            $endTime = Carbon::parse($event->start_date . ' ' . $event->timein_end_am);

            // Restrict attendance to the time-in AM window
            if (!$currentTime->between($startTime, $endTime)) {
                return redirect()->back()->with('error', 'Attendance for Time-in (AM) is only allowed between ' . $event->timein_start_am . ' and ' . $event->timein_end_am . '.');
            }
            break;

        case 'Time-out (AM)':
            $startTime = Carbon::parse($event->start_date . ' ' . $event->timeout_start_am);

            // Restrict attendance to the time-out AM window after timeout_start_am
            if ($currentTime->lessThan($startTime)) {
                return redirect()->back()->with('error', 'Attendance for Time-out (AM) cannot be recorded until after ' . $event->timeout_start_am . '.');
            }
            break;

        case 'Time-in (PM)':
            $startTime = Carbon::parse($event->start_date . ' ' . $event->timein_start_pm);
            $endTime = Carbon::parse($event->start_date . ' ' . $event->timein_end_pm);

            // Restrict attendance to the time-in PM window
            if (!$currentTime->between($startTime, $endTime)) {
                return redirect()->back()->with('error', 'Attendance for Time-in (PM) is only allowed between ' . $event->timein_start_pm . ' and ' . $event->timein_end_pm . '.');
            }
            break;

        case 'Time-out (PM)':
            $startTime = Carbon::parse($event->start_date . ' ' . $event->timeout_start_pm);

            // Restrict attendance to the time-out PM window after timeout_start_pm
            if ($currentTime->lessThan($startTime)) {
                return redirect()->back()->with('error', 'Attendance for Time-out (PM) cannot be recorded until after ' . $event->timeout_start_pm . '.');
            }
            break;

        default:
            return redirect()->back()->with('error', 'Invalid attendance period.');
    }

    // Check if an attendance record already exists for this student, event, and attendance period
    $existingAttendance = Attendance::where('student_rfid', $student->rfid)
        ->where('event_id', $request->event_id)
        ->where('attendance_period', $request->attendance_period)
        ->first();

    if ($existingAttendance) {
        return redirect()->back()->with('error', 'Attendance already recorded for this period.');
    }

    // Create the attendance record
    Attendance::create([
        'student_id' => $student->id,
        'student_rfid' => $student->rfid,
        'event_id' => $request->event_id,
        'attendance_period' => $request->attendance_period,
        'attended_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Attendance recorded successfully.');
}

public function recordAttendance(Request $request)
    {
        // Log request details for debugging purposes
        \Log::info('Record attendance request:', $request->all());

        $rfid = $request->input('rfid');
        $eventId = $request->input('event_id');

        // Retrieve the student and include course and year data
    $student = Student::with('courseYear')->where('rfid', $rfid)->first();

        if (!$student) {
            \Log::error('Student not found for RFID:', ['rfid' => $rfid]);
            return response()->json(['error' => 'Student not found.'], 404);
        }

        // Get the event
        $event = Event::find($eventId);
        if (!$event) {
            return response()->json(['error' => 'Event not found.'], 404);
        }

        // Check the event attendees_type
        if ($event->attendees_type == 'officers') {
            // Check if the student is an officer
            $isOfficer = Officer::where('student_id', $student->id)->exists();
            if (!$isOfficer) {
                \Log::warning('Non-officer student trying to attend officer-only event:', ['student_id' => $student->id]);
                return response()->json([
                    'error' => 'Only officers can attend this event.',
                    'message' => 'You are not an officer and cannot attend this event.'
                ], 403);
            }
        }

        // Time period logic
        $now = Carbon::now();
        $timeinStartAm = Carbon::parse($event->start_date . ' ' . $event->timein_start_am);
        $timeinEndAm = Carbon::parse($event->start_date . ' ' . $event->timein_end_am);
        $timeoutStartAm = Carbon::parse($event->start_date . ' ' . $event->timeout_start_am);
        $timeoutEndAm = Carbon::parse($event->start_date . ' ' . $event->timeout_end_am);

        $timeinStartPm = Carbon::parse($event->start_date . ' ' . $event->timein_start_pm);
        $timeinEndPm = Carbon::parse($event->start_date . ' ' . $event->timein_end_pm);
        $timeoutStartPm = Carbon::parse($event->start_date . ' ' . $event->timeout_start_pm);
        $timeoutEndPm = Carbon::parse($event->start_date . ' ' . $event->timeout_end_pm);

        // Initialize the period
        $period = null;

        if ($now->between($timeinStartAm, $timeinEndAm)) {
            $period = 'Time-in (AM)';
        } elseif ($now->between($timeoutStartAm, $timeoutEndAm)) {
            $period = 'Time-out (AM)';
        } elseif ($now->between($timeinStartPm, $timeinEndPm)) {
            $period = 'Time-in (PM)';
        } elseif ($now->between($timeoutStartPm, $timeoutEndPm)) {
            $period = 'Time-out (PM)';
        }

        if (!$period) {
            return response()->json(['error' => 'Invalid time period.'], 400);
        }

        // Check for duplicate attendance
        $existingAttendance = Attendance::where('student_rfid', $rfid)
            ->where('event_id', $eventId)
            ->where('attendance_period', $period)
            ->first();

        if ($existingAttendance) {
            \Log::warning('Duplicate attendance attempt for student:', ['student_id' => $student->id, 'period' => $period]);
            return response()->json(['error' => 'Attendance already recorded for this event in ' . $period . '.'], 409);
        }

        // Record attendance
        Attendance::create([
            'student_id' => $student->id,
            'student_rfid' => $rfid,
            'event_id' => $eventId,
            'attendance_period' => $period,
            'attended_at' => $now,
        ]);

        // Return success
        return response()->json([
            'success' => 'Attendance recorded successfully for ' . $period . '.',
            'student' => $student
        ], 200);
    }


public function absent()
{
    // Fetch absent students data
    $absentStudents = Student::where('status', 'absent')->get();

    return view('attendance.absent', [
        'absentStudents' => $absentStudents
    ]);
}


    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');    }
        public function getEvents(Request $request)
{
    $event = Event::find($request->id);
    
    if ($event) {
        return response()->json(['success' => true, 'event_name' => $event->event_name]);
    } else {
        return response()->json(['success' => false]);
    }
}
public function attendanceChart()
{
    $events = Event::all(); // Get all events for dropdown filter
    return view('attendance_chart', compact('events'));
}

public function getAttendanceData(Request $request)
{
    $eventId = $request->event_id;
    $event = Event::findOrFail($eventId); // Ensure the event exists

    $totalStudents = Student::count(); // Get total students
    $attendances = Attendance::where('event_id', $eventId)->get();
    $attendedStudentIds = $attendances->pluck('student_id')->toArray();

    $present = count(array_unique($attendedStudentIds));
    $partiallyAbsent = 0; // You can modify this if needed
    $absent = $totalStudents - $present;

    return response()->json([
        'present' => round(($present / $totalStudents) * 100, 2),
        'partially_absent' => round(($partiallyAbsent / $totalStudents) * 100, 2),
        'absent' => round(($absent / $totalStudents) * 100, 2),
    ]);
}

}
