<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Fine;
use App\Models\Student;
use App\Models\CourseYear;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Student_StudentController extends Controller
{
    public function index()
    {
        // Fetch all students with their payments
        $students = Student::with('payments')->get();
    
        // Fetch all contributions globally
        $contributions = Contribution::with('event')->get();
    
        // Group contributions by event
        $groupedContributions = $contributions->groupBy('event_id');
    
        // Fetch fines grouped by student and event, summing their total amounts
        foreach ($students as $student) {
            // Fetch fines for the student, grouping by event
            $student->fines = Fine::select('event_id', DB::raw('SUM(amount) as total_fine'))
                ->where('student_id', $student->id)
                ->groupBy('event_id')
                ->with('event') // Load event details
                ->get();
    
            // Calculate the total fine amount for this student
            $totalFines = $student->fines->sum('total_fine');
    
            // Calculate total contributions for this student
            $totalContributions = 0;
    
            // Sum contributions grouped by event related to this student
            foreach ($student->fines as $fine) {
                $eventContributions = $groupedContributions->get($fine->event_id, collect());
                $totalContributions += $eventContributions->sum('amount');
            }
    
            // Also consider global contributions that are not tied to any event
            $globalContributions = $groupedContributions->get(null, collect());
            $totalContributions += $globalContributions->sum('amount');
    
            // Calculate the total fees by summing contributions and fines
            // Do not format here, keep it as a float or integer
            $student->totalFees = $totalContributions + $totalFines; 
        }
    
        // Format totalFees for display in the view
        foreach ($students as $student) {
            $student->formattedTotalFees = number_format($student->totalFees, 2, '.', ',');
        }
    
        // Fetch all clubs and course years to populate modals
        $clubs = Club::all(); // Fetch all clubs
        $courseYears = CourseYear::all(); // Fetch all course years
    
        return view('student_student.index', compact('students', 'groupedContributions', 'clubs', 'courseYears'));

    }
    
}
