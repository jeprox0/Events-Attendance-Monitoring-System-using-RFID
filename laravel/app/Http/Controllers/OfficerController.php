<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Student;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    // Display a listing of the officers
    public function index()
    {
        // Retrieve officers with related student and club data
        $officers = Officer::with(['student', 'club'])->get(); 

        // Retrieve students for the modal dropdown (optional)
        // If you want to list students with their clubs as well
        $students = Student::with('clubs')->get(); 
        
        return view('officers.index', compact('officers', 'students')); // Pass both officers and students to the view
    }

    // Store a newly created officer in storage
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id', // Validate that the student exists
            'club_id' => 'required|exists:clubs,id', // Validate that the club exists
            'position_name' => 'required|string|max:255', // Validate position as a string
        ]);

        // Create a new officer with the student_id, club_id, and position_name
        Officer::create($request->only(['student_id', 'club_id', 'position_name']));

        return redirect()->route('officers.index')->with('success', 'Officer added successfully.');
    }

    // Update the officer
    public function update(Request $request, Officer $officer)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'club_id' => 'required|exists:clubs,id', // Validate that the club exists
            'position_name' => 'required|string|max:255',
        ]);

        // Update the officer with the student_id, club_id, and position_name
        $officer->update($request->only(['student_id', 'club_id', 'position_name']));

        return redirect()->route('officers.index')->with('success', 'Officer updated successfully.');
    }

    // Delete the officer
    public function destroy(Officer $officer)
    {
        $officer->delete();
        return redirect()->route('officers.index')->with('success', 'Officer deleted successfully.');
    }
}
