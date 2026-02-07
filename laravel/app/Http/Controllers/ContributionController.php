<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Semester;
use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {
        // Get the current semester
        $currentSemester = Semester::where('status', 'Current')->first();
        
        // Filter events based on the current semester
        $events = $currentSemester ? Event::where('semester_id', $currentSemester->id)->get() : collect();
        
        // Fetch all contributions and semesters
        $contributions = Contribution::all();
        $semesters = Semester::all();
        
        return view('contributions.index', compact('contributions', 'events', 'semesters'));
    }

    public function create()
    {
        // Get the current semester
        $currentSemester = Semester::where('status', 'Current')->first();
        
        // Filter events based on the current semester
        $events = $currentSemester ? Event::where('semester_id', $currentSemester->id)->get() : collect();
        
        // Fetch all semesters
        $semesters = Semester::all();
        
        return view('contributions.create', compact('events', 'semesters'));
    }

    

    public function store(Request $request)
{
    // Validate the input, including 'semester_id'
    $validatedData = $request->validate([
        'amount' => 'required|numeric',
        'type' => 'required|string',
        'event_id' => 'nullable|exists:events,id', // Optional event selection
        'semester_id' => 'required|exists:semesters,id', // Make sure the semester exists
    ]);

    // Store the contribution with semester_id
    Contribution::create([
        'amount' => $validatedData['amount'],
        'type' => $validatedData['type'],
        'event_id' => $validatedData['event_id'] ?? null, // Use null if event is optional
        'semester_id' => $validatedData['semester_id'], // Include semester ID
        'user_id' => auth()->id(), // Assuming the user is authenticated
    ]);

    // Redirect back with success message
    return redirect()->route('contributions.index')->with('success', 'Contribution added successfully.');
}

     // Show the form for editing a contribution
     public function edit($id)
     {
        $contributions = Contribution::findOrFail($id);
        $events = Event::all(); // Fetch all events
        return view('contributions.edit', compact('contributions', 'events'));
     }
 
     // Update a contribution in the database
     public function update(Request $request, Contribution $contribution)
     {
         $request->validate([
             'type' => 'required|string',
             'amount' => 'required|numeric',
             'event_id' => 'nullable|exists:events,id',
             'semester_id' => 'required|exists:semesters,id', // Ensure the semester is valid
         ]);
     
         // Update the contribution including the semester_id
         $contribution->update([
             'type' => $request->type,
             'amount' => $request->amount,
             'event_id' => $request->event_id,
             'semester_id' => $request->semester_id, // Store the semester_id
         ]);
     
         return redirect()->route('contributions.index')->with('success', 'Contribution updated successfully.');
     }
     
     // Delete a contribution from the database
     public function destroy($id)
     {
         $contribution = Contribution::findOrFail($id);
         $contribution->delete();
 
         return redirect()->route('contributions.index')->with('success', 'Contribution deleted successfully.');
     }
}
