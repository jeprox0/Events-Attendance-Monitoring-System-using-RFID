<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::all(); // Fetch all clubs
        return view('clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('clubs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'club_name' => 'required|string|max:255',
        ]);

        Club::create($request->all());

        return redirect()->route('clubs.index')->with('success', 'Club created successfully.');
    }

    public function edit($id)
    {
        $club = Club::findOrFail($id);
        return view('clubs.edit', compact('club'));
    }

    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);

        $request->validate([
            'club_name' => 'required|string|max:255',
        ]);

        $club->update($request->all());

        return redirect()->route('clubs.index')->with('success', 'Club updated successfully.');
    }

    public function destroy($id)
    {
        $club = Club::findOrFail($id);
        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Club deleted successfully.');
    }
}
