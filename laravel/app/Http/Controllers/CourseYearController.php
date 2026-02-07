<?php

namespace App\Http\Controllers;

use App\Models\CourseYear;
use Illuminate\Http\Request;

class CourseYearController extends Controller
{
    public function index()
    {
        $courses = CourseYear::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
        ]);

        CourseYear::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    public function edit(CourseYear $courseYear)
    {
        return view('courses.edit', compact('courseYear'));
    }

    public function update(Request $request, CourseYear $course) {
        $request->validate([
            'course_name' => 'required|string',
            'year_level' => 'required|string',
            
        ]);
    
        $course->update($request->all());
    
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(CourseYear $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
