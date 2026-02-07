<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the total number of students
        $totalStudents = Student::count();
    
        // Get the total number of upcoming events
        $totalUpcomingEvents = Event::where('status', 'upcoming')->count();
    
        // Get all ongoing events
        $ongoingEvents = Event::where('status', 'ongoing')->get();
    
        // Get all completed events, ordering by the latest time (either endtime_am or endtime_pm)
        $completedEvents = Event::where('status', 'completed')
            ->orderByRaw("GREATEST(COALESCE(endtime_pm, '1970-01-01'), COALESCE(endtime_am, '1970-01-01')) DESC")
            ->get();
    
        // Return the view with the necessary data
        return view('dashboard', compact('totalStudents', 'totalUpcomingEvents', 'ongoingEvents', 'completedEvents'));
    }
}    