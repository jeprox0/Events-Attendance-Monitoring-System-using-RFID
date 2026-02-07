<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Event;
use App\Models\Student;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
{
    // Get the total number of students
    $totalStudents = Student::count();

    // Get the total number of upcoming events
    $upcomingEvents = Event::where('status', 'upcoming')->get(['event_name', 'start_date']);
    $totalUpcomingEvents = $upcomingEvents->count();

    // Get all ongoing events
    $ongoingEvents = Event::where('status', 'ongoing')->get();

    // Get all completed events, ordering by the latest time (either endtime_am or endtime_pm)
    $completedEvents = Event::where('status', 'completed')
        ->orderByRaw("GREATEST(COALESCE(endtime_pm, '1970-01-01'), COALESCE(endtime_am, '1970-01-01')) DESC")
        ->get();

    // Fetch all event IDs in the fines table
    $finedEventIds = Fine::pluck('event_id')->unique();

    // Return the view with the necessary data
    return view('student-dashboard', compact('totalStudents', 'totalUpcomingEvents', 'ongoingEvents', 'completedEvents', 'upcomingEvents', 'finedEventIds'));
}

}
