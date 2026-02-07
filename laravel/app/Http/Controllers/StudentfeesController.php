<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Fine;
use App\Models\Student;
use App\Models\CourseYear;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentfeesController extends Controller
{
    public function index()
    {
        // Fetch all students with their payments
        $students = Student::with('payments')->get();
    
        // Fetch all contributions grouped by semester
        $contributions = Contribution::all()->groupBy('semester_id');
    
        // Process each student
        foreach ($students as $student) {
            // Fetch fines for the student
            $student->fines = Fine::select('event_id', DB::raw('SUM(amount) as total_fine'))
                ->where('student_id', $student->id)
                ->groupBy('event_id')
                ->get();
    
            // Initialize total fees for the student
            $totalFines = $student->fines->sum('total_fine');
            $totalContributions = 0;
    
            // Initialize collection for contributions
            $studentContributions = collect();
    
            // Add contributions for each semester
            foreach ($contributions as $semester_id => $semesterContributions) {
                // Add contributions for this semester
                $studentContributions = $studentContributions->merge($semesterContributions);
                $totalContributions += $semesterContributions->sum('amount');
            }
    
            // Calculate total fees (contributions + fines)
            $student->totalFees = $totalContributions + $totalFines;
    
            // Group contributions by semester for the student
            $student->groupedContributions = $studentContributions->groupBy('semester_id');
        }
    
        // Format totalFees for display in the view
        foreach ($students as $student) {
            $student->formattedTotalFees = number_format($student->totalFees, 2, '.', ',');
        }
    
        // Fetch all clubs and course years to populate modals
        $clubs = Club::all(); // Fetch all clubs
        $courseYears = CourseYear::all(); // Fetch all course years
    
        return view('student_fees.index', compact('students', 'contributions', 'clubs', 'courseYears'));
    }
    
}
