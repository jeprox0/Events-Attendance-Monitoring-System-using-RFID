<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fine;
use App\Models\User;
use App\Models\Event;
use App\Models\Student;
use App\Models\Semester;
use App\Events\EventEnded;
use App\Models\Attendance;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Retrieve all events
    $events = Event::all();
    $semesters = Semester::all();
    // Loop through the events and update their statuses
    foreach ($events as $event) {
        $event->updateStatus(); // Update the status of each event
        
        // Convert date and time fields to Carbon instances for formatting
        $event->start_date = $event->start_date ? Carbon::parse($event->start_date) : null;
        $event->starttime_am = $event->starttime_am ? Carbon::parse($event->starttime_am) : null;
        $event->endtime_am = $event->endtime_am ? Carbon::parse($event->endtime_am) : null;
        $event->starttime_pm = $event->starttime_pm ? Carbon::parse($event->starttime_pm) : null;
        $event->endtime_pm = $event->endtime_pm ? Carbon::parse($event->endtime_pm) : null;
        
        // Parse time-in and time-out fields
        $event->timein_start_am = $event->timein_start_am ? Carbon::parse($event->timein_start_am) : null;
        $event->timein_end_am = $event->timein_end_am ? Carbon::parse($event->timein_end_am) : null;
        $event->timeout_start_am = $event->timeout_start_am ? Carbon::parse($event->timeout_start_am) : null;
        $event->timeout_end_am = $event->timeout_end_am ? Carbon::parse($event->timeout_end_am) : null;
        $event->timein_start_pm = $event->timein_start_pm ? Carbon::parse($event->timein_start_pm) : null;
        $event->timein_end_pm = $event->timein_end_pm ? Carbon::parse($event->timein_end_pm) : null;
        $event->timeout_start_pm = $event->timeout_start_pm ? Carbon::parse($event->timeout_start_pm) : null;
        $event->timeout_end_pm = $event->timeout_end_pm ? Carbon::parse($event->timeout_end_pm) : null;
    }

    // Return the view with the events
    return view('event.index', compact('events', 'semesters'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view to create a new event
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input fields based on the selected half-day option
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attendees_type' => 'nullable|string',
            'start_date' => 'required|date',
            'semester_id' => 'required|exists:semesters,id', 
            'halfday_option' => 'required|in:morning,afternoon,wholeday', // Ensure half-day option is selected
            'starttime_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'endtime_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'timein_start_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'timein_end_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'timeout_start_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'timeout_end_am' => 'nullable|required_if:halfday_option,morning,wholeday|date_format:H:i',
            'starttime_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
            'endtime_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
            'timein_start_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
            'timein_end_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
            'timeout_start_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
            'timeout_end_pm' => 'nullable|required_if:halfday_option,afternoon,wholeday|date_format:H:i',
        ]);
    
        // Combine start date with AM or PM start and end times for event timing
        if ($request->halfday_option === 'morning' || $request->halfday_option === 'wholeday') {
            $startDateTime = Carbon::parse($request->start_date . ' ' . $request->starttime_am);
            $endDateTime = Carbon::parse($request->start_date . ' ' . $request->endtime_am);
        }
    
        if ($request->halfday_option === 'afternoon' || $request->halfday_option === 'wholeday') {
            $startDateTime = Carbon::parse($request->start_date . ' ' . $request->starttime_pm);
            $endDateTime = Carbon::parse($request->start_date . ' ' . $request->endtime_pm);
        }
    
        // Determine event status based on current time and event times
        $now = Carbon::now();
        $status = 'upcoming';
        if ($now->between($startDateTime, $endDateTime)) {
            $status = 'ongoing';
        } elseif ($now->greaterThan($endDateTime)) {
            $status = 'completed';
        }
    
        // Create the event with the authenticated user's ID
        $event = Event::create([
            'event_name' => $request->event_name,
            'description' => $request->description,
            'attendees_type' => $request->attendees_type,
            'semester_id' => $request->semester_id,
            'start_date' => $request->start_date,
            'status' => $status,
            'user_id' => auth()->id(),
        ]);
    
        // Set AM or PM fields only if applicable
        if ($request->halfday_option === 'morning' || $request->halfday_option === 'wholeday') {
            $event->update([
                'starttime_am' => $request->starttime_am,
                'endtime_am' => $request->endtime_am,
                'timein_start_am' => $request->timein_start_am,
                'timein_end_am' => $request->timein_end_am,
                'timeout_start_am' => $request->timeout_start_am,
                'timeout_end_am' => $request->timeout_end_am,
            ]);
        }
    
        if ($request->halfday_option === 'afternoon' || $request->halfday_option === 'wholeday') {
            $event->update([
                'starttime_pm' => $request->starttime_pm,
                'endtime_pm' => $request->endtime_pm,
                'timein_start_pm' => $request->timein_start_pm,
                'timein_end_pm' => $request->timein_end_pm,
                'timeout_start_pm' => $request->timeout_start_pm,
                'timeout_end_pm' => $request->timeout_end_pm,
            ]);
        }
    
        // Redirect with a success message
        return redirect()->route('event.index')->with('success', 'Event created successfully.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $event->updateStatus(); // Update status dynamically
        return view('event.show', compact('event'));
    }
    
    /**
 * Update the specified resource in storage.
 */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    // Validate the incoming request
    $request->validate([
        'event_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'attendees_type' => 'nullable|string',
        'start_date' => 'required|date',
        'starttime_am' => 'nullable|date_format:H:i',
        'endtime_am' => 'nullable|date_format:H:i',
        'timein_start_am' => 'nullable|date_format:H:i',
        'timein_end_am' => 'nullable|date_format:H:i',
        'timeout_start_am' => 'nullable|date_format:H:i',
        'timeout_end_am' => 'nullable|date_format:H:i',
        'starttime_pm' => 'nullable|date_format:H:i',
        'endtime_pm' => 'nullable|date_format:H:i',
        'timein_start_pm' => 'nullable|date_format:H:i',
        'timein_end_pm' => 'nullable|date_format:H:i',
        'timeout_start_pm' => 'nullable|date_format:H:i',
        'timeout_end_pm' => 'nullable|date_format:H:i',
    ]);

    // Find the event by ID
    $event = Event::findOrFail($id);

    // Get the current date and time
    $now = \Carbon\Carbon::now();

    // Create Carbon instances for start and end times
    $startDateTimeAM = \Carbon\Carbon::parse($request->start_date . ' ' . ($request->starttime_am ?: '00:00'));
    $endDateTimeAM = \Carbon\Carbon::parse($request->start_date . ' ' . ($request->endtime_am ?: '23:59'));
    $startDateTimePM = \Carbon\Carbon::parse($request->start_date . ' ' . ($request->starttime_pm ?: '00:00'));
    $endDateTimePM = \Carbon\Carbon::parse($request->start_date . ' ' . ($request->endtime_pm ?: '23:59'));

    // Parse attendance period times
    $timeinStartAM = \Carbon\Carbon::parse($request->timein_start_am ?: '00:00');
    $timeinEndAM = \Carbon\Carbon::parse($request->timein_end_am ?: '23:59');
    $timeoutStartAM = \Carbon\Carbon::parse($request->timeout_start_am ?: '00:00');
    $timeoutEndAM = \Carbon\Carbon::parse($request->timeout_end_am ?: '23:59');

    $timeinStartPM = \Carbon\Carbon::parse($request->timein_start_pm ?: '00:00');
    $timeinEndPM = \Carbon\Carbon::parse($request->timein_end_pm ?: '23:59');
    $timeoutStartPM = \Carbon\Carbon::parse($request->timeout_start_pm ?: '00:00');
    $timeoutEndPM = \Carbon\Carbon::parse($request->timeout_end_pm ?: '23:59');

    // Determine the event status
    $status = 'upcoming';
    if ($now->between($startDateTimeAM, $endDateTimeAM) || $now->between($startDateTimePM, $endDateTimePM)) {
        $status = 'ongoing';
    } elseif ($now->greaterThan($endDateTimePM)) {
        $status = 'completed';
    }

    // Update the event details
    $event->update([
        'event_name' => $request->event_name,
        'description' => $request->description,
        'attendees_type' => $request->attendees_type,
        'start_date' => $request->start_date,
        'starttime_am' => $request->starttime_am,
        'endtime_am' => $request->endtime_am,
        'timein_start_am' => $request->timein_start_am,
        'timein_end_am' => $request->timein_end_am,
        'timeout_start_am' => $request->timeout_start_am,
        'timeout_end_am' => $request->timeout_end_am,
        'starttime_pm' => $request->starttime_pm,
        'endtime_pm' => $request->endtime_pm,
        'timein_start_pm' => $request->timein_start_pm,
        'timein_end_pm' => $request->timein_end_pm,
        'timeout_start_pm' => $request->timeout_start_pm,
        'timeout_end_pm' => $request->timeout_end_pm,
        'status' => $status,
        'user_id' => auth()->id(),
    ]);

    // Generate fines for students who did not attend if the event is completed
    if ($status === 'completed') {
        $event->generateFinesForAbsentees();
    }

    // Redirect to the event index with a success message
    return redirect()->route('event.index')->with('success', 'Event updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the event by ID and delete it
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
    }
}
