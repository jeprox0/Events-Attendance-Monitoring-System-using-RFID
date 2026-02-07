<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Event;
use App\Models\Excuse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExcuseController extends Controller
{

   public function index(Request $request)
{
    $query = Excuse::query();

    // Check if an event_id is provided in the request
    if ($request->filled('event_id')) {
        $query->where('event_id', $request->event_id);
    }

    $excusedStudents = $query->with('student', 'event')->get(); // Eager load relationships

    $events = Event::all(); // Get all events for the filter

    return view('excused_students.index', compact('excusedStudents', 'events'));
}

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'event_id' => 'required|exists:events,id',
            'reason' => 'required|string',
            'picture' => '|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate picture
        ]);

        // Store the picture
        $picturePath = $request->file('picture')->store('excuse_pictures', 'public');

        // Insert into the excused_students table
        Excuse::create([
            'student_id' => $request->student_id,
            'event_id' => $request->event_id,
            'reason' => $request->reason,
            'picture' => $picturePath,  // Store the path to the picture
        ]);

        // Delete the fines for this student for this event
        Fine::where('student_id', $request->student_id)
            ->where('event_id', $request->event_id)
            ->delete();

        return redirect()->back()->with('success', 'Student excused and fines removed.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Find the existing excuse by its ID
    $excuse = DB::table('excused_students')->where('id', $id)->first();

    // Validate the input
    $request->validate([
        'reason' => 'required|string',
        'excuse_letter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
    ]);

    // Check if a new excuse letter (picture) is uploaded
    if ($request->hasFile('excuse_letter')) {
        // Remove the old excuse letter if it exists
        if ($excuse->picture && file_exists(public_path('uploads/excuses/' . $excuse->picture))) {
            unlink(public_path('uploads/excuses/' . $excuse->picture));
        }

        // Upload the new picture
        $picture = $request->file('excuse_letter');
        $filename = time() . '_' . $picture->getClientOriginalName();
        $picture->move(public_path('uploads/excuses'), $filename);
    } else {
        // If no new file is uploaded, retain the old picture
        $filename = $excuse->picture;
    }

    // Update the excused student's record in the database
    DB::table('excused_students')->where('id', $id)->update([
        'reason' => $request->input('reason'),
        'picture' => $filename,  // Update picture only if new one uploaded
        'updated_at' => now(),
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Excuse updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
