<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    // Show the list of semesters
    public function index()
    {
        $semesters = Semester::all();
        return view('semesters.index', compact('semesters'));
    }

    // Show the form for creating a new semester
    public function create()
    {
        return view('semesters.create');
    }

    // Store a new semester in the database
    // Store a new semester in the database
public function store(Request $request)
{
    $request->validate([
        'school_year' => 'required|string',
        'semester' => 'required|in:First,Second',
    ]);

    // Update the status of the current semester to "End"
    Semester::where('status', 'Current')->update(['status' => 'Ended']);

    // Create the new semester and set it as "Current"
    Semester::create([
        'school_year' => $request->school_year,
        'semester' => $request->semester,
        'status' => 'Current',
    ]);

    return redirect()->route('semesters.index')->with('success', 'Semester created successfully.');
}


    // Show the form for editing an existing semester
    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    // Update the semester in the database
    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'school_year' => 'required|string',
            'semester' => 'required|in:First,Second',
        ]);

        $semester->update($request->all());
        return redirect()->route('semesters.index')->with('success', 'Semester updated successfully.');
    }

    // Delete a semester
    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semesters.index')->with('success', 'Semester deleted successfully.');
    }
}
