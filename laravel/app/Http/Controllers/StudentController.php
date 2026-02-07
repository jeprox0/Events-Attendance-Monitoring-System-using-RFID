<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Fine;
use App\Models\User;
use App\Models\Student;
use App\Models\CourseYear;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Semester;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch all students with their payments
        $students = Student::with('payments')->get();
        $semesters = Semester::all();
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
    
        return view('student.index', compact('students', 'semesters','contributions', 'clubs', 'courseYears'));
    }
    
    public function studentIndex()
    {
        // Get the logged-in user's student ID
        $studentId = auth()->user()->student_id;
    
        // Fetch the student with their payments using the student ID
        $student = Student::with('payments')->findOrFail($studentId);
        
        // Fetch all contributions grouped by semester
        $contributions = Contribution::all()->groupBy('semester_id');
    
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
    
        // Format totalFees for display in the view
        $student->formattedTotalFees = number_format($student->totalFees, 2, '.', ',');
    
        return view('student-student.index', compact('student', 'contributions'));
    }
    
public function create()
{
    // Retrieve the RFID UID from your Node.js server
    $rfid = $this->getRFID();

    // Fetch clubs and course years from the database
    $clubs = Club::all(); // Retrieve all clubs
    $courseYears = CourseYear::all(); // Retrieve all course years

    return view('student.create', compact('rfid', 'clubs', 'courseYears'));
}


public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:students,email|unique:users,email',
        'course_year_id' => 'nullable|string|max:255', // Make course_year_id nullable
        'club_ids' => 'nullable|array', // Validate that club_ids is an array (since it's multiple)
        'club_ids.*' => 'nullable|integer|exists:clubs,id', // Each selected club must exist in the clubs table
        'picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'rfid' => 'required|string|max:255|unique:students,rfid',
        'semester_id' => 'required|string|max:255',
    ]);

    $filePath = null;
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/students', $fileName, 'public');
    }

    // Get the currently logged-in user
    $loggedInUser = auth()->user();

    // Create a new student record
    $student = new Student();
    $student->first_name = $request->first_name;
    $student->last_name = $request->last_name;
    $student->email = $request->email;
    $student->course_year_id = $request->course_year_id; // This can now be null
    $student->rfid = $request->rfid;
    $student->semester_id = $request->semester_id;
    $student->picture = $filePath; // Save the file path or leave it as null
    $student->user_id = $loggedInUser->id; // Set the user_id to the logged-in user's ID
    $student->save();

    // Sync clubs - Many-to-many relationship (assuming you have set up the relationship)
    if ($request->has('club_ids')) {
        $student->clubs()->sync($request->club_ids); // Sync the selected clubs with the student
    }

    // Create a corresponding user account for the student
    User::create([
        'student_id' => $student->id, // Link to the student record
        'name' => $student->first_name . ' ' . $student->last_name,
        'email' => $student->email,
        'password' => Hash::make($student->rfid), // Use RFID as the password
        'role' => 'user',
    ]);

    return redirect()->route('student.index')->with('success', 'Student added successfully.');
}


public function checkEmail(Request $request)
{
    $exists = Student::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
}

// In StudentController.php
public function checkRFID(Request $request)
{
    $exists = Student::where('rfid', $request->rfid)->exists();
    return response()->json(['exists' => $exists]);
}

    private function getRFID()
    {
        $url = 'http://localhost:5000/card';  // Adjust the URL as necessary
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['uid'] ?? 'No RFID detected';
    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courseYears = CourseYear::all();
        $clubs = Club::all();
    
        return view('student.index', compact('student', 'courseYears', 'clubs'));
    }

    public function show($id)
    {
        $student = Student::with(['payments', 'fines', 'groupedContributions'])->find($id);
        
        // Check if student is null
        if (!$student) {
            abort(404, 'Student not found.');
        }
    
        // Debug output
        dd($student);
        
        return view('student-student.show', compact('student'));
    }
    

    

    public function update(Request $request, Student $student)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'rfid' => 'required|string|max:255',
            'course_year_id' => 'nullable|exists:courses_years,id', // Course year validation
            'clubs' => 'nullable|array', // Validate as an array of club IDs
            'clubs.*' => 'exists:clubs,id', // Ensure each club ID exists
            'picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        // Update student details
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->rfid = $request->rfid;
    
        // Assign course_year_id
        $student->course_year_id = $request->course_year_id;
    
        // Handle picture upload
        if ($request->hasFile('picture')) {
            // Delete old picture if it exists
            if ($student->picture) {
                Storage::delete('public/' . $student->picture);
            }
    
            // Store new picture
            $file = $request->file('picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/students', $fileName, 'public');
    
            // Update the picture path in the database
            $student->picture = $filePath;
        }
    
        // Save the student details
        $student->save();
    
        // Sync the clubs (handle many-to-many relationship)
        if ($request->has('clubs')) {
            $student->clubs()->sync($request->clubs); // Update clubs in the pivot table
        } else {
            $student->clubs()->detach(); // If no clubs are selected, detach all
        }
    
        return redirect('/student')->with('success', 'Student updated successfully.');
    }
    



public function destroy($id)
{
    // Find the student by ID
    $student = Student::findOrFail($id);

    // Check if the student has a related user
    $user = User::where('student_id', $student->id)->first();

    if ($user) {
        // Delete the associated user if found
        $user->delete();
    }

    // Now delete the student
    $student->delete();

    // Redirect with a success message
    return redirect('/student')->with('success', 'Student deleted successfully.');
}

}