<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Event;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FineController extends Controller
{
    public function index(Request $request)
{
    // Get the event filter if applied and fetch fines grouped by student and event
    $fines = Fine::select('student_id', 'event_id', DB::raw('SUM(amount) as total_fine'))
        ->when($request->event_id, function($query) use ($request) {
            return $query->where('event_id', $request->event_id);
        })
        ->groupBy('student_id', 'event_id')
        ->with(['student', 'event'])
        ->get();

    $students = Student::all();
    $events = Event::all();

    return view('fine.index', compact('fines', 'students', 'events'));
}

public function excuseStudent(Request $request)
{
    $studentId = $request->student_id;
    $eventId = $request->event_id;

    // Validate the request input
    $request->validate([
        'reason' => 'required|string',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the file upload for the excuse letter (picture)
    $filename = null;  
    if ($request->hasFile('picture')) {
        $picture = $request->file('picture');
        $filename = time() . '_' . $picture->getClientOriginalName();
        $picture->move(public_path('uploads/excuses'), $filename);
    }

    // Get the currently logged-in user
    $loggedInUser = auth()->user();

    // Insert the data into the excused_students table
    DB::table('excused_students')->insert([
        'student_id' => $studentId,
        'event_id' => $eventId,
        'reason' => $request->reason,
        'picture' => $filename,
        'user_id' => $loggedInUser->id, // Log the user who excused the student
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Delete all fines for that specific student and event
    DB::table('fines')
        ->where('student_id', $studentId)
        ->where('event_id', $eventId)
        ->delete();

    return redirect()->back()->with('success', 'The student is excused.');
}


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        // Retrieve the event
        $event = Event::find($request->event_id);

        // If fines have already been generated for this event, return an error
        $finesAlreadyGenerated = Fine::where('event_id', $event->id)->exists();

        if ($finesAlreadyGenerated) {
            return redirect()->back()->with('error', 'Fines have already been generated for this event.');
        }

        // Use a transaction to ensure data consistency
        DB::transaction(function () use ($event) {
            // Get all students
            $students = Student::all();

            // Generate fines for each attendance period
            $this->generateFinesForPeriod($students, $event, 'timein_start_am', 'timein_end_am', 'timein_am', 25);
            $this->generateFinesForPeriod($students, $event, 'timeout_start_am', 'timeout_end_am', 'timeout_am', 25);
            $this->generateFinesForPeriod($students, $event, 'timein_start_pm', 'timein_end_pm', 'timein_pm', 25);
            $this->generateFinesForPeriod($students, $event, 'timeout_start_pm', 'timeout_end_pm', 'timeout_pm', 25);
        });

        return redirect()->back()->with('success', 'Fines generated for students who did not attend within the specified periods.');
    }

    protected function generateFinesForPeriod($students, $event, $startPeriod, $endPeriod, $periodEnumValue, $fineAmount)
    {
        // Ensure both start and end times for the period are set
        if (is_null($event->$startPeriod) || is_null($event->$endPeriod)) {
            return; // Skip if the time period is not defined
        }

        // Define the start and end time for the period
        $startTime = \Carbon\Carbon::parse($event->start_date . ' ' . $event->$startPeriod);
        $endTime = \Carbon\Carbon::parse($event->start_date . ' ' . $event->$endPeriod);

        // Only generate fines if the period has already passed
        if (\Carbon\Carbon::now()->greaterThan($endTime)) {
            foreach ($students as $student) {
                // **Check officer status** if event is for officers only
                if ($event->attendees_type == 'officers') {
                    $isOfficer = Officer::where('student_id', $student->id)->exists();
                    if (!$isOfficer) {
                        continue; // Skip fining non-officers for officer-only events
                    }
                }

                // Check if the student attended within this specific time period
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('event_id', $event->id)
                    ->whereBetween('created_at', [$startTime, $endTime])
                    ->exists();

                // If the student didn't attend, generate a fine
                if (!$attendance) {
                    Fine::create([
                        'student_id' => $student->id,
                        'event_id' => $event->id,
                        'amount' => $fineAmount,
                        'attendance_period' => $periodEnumValue, // Enum value for period (e.g., timein_am, timeout_pm)
                    ]);
                }
            }
        }
    }
}
