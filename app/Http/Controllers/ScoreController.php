<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::all();
        return response()->json($scores);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservationid' => 'required|integer',
            'points' => 'required|integer',
            'round' => 'required|integer',
            'isactive' => 'required|boolean',
            'note' => 'nullable|string|max:255',
            'datecreated' => 'required|date',
            'datemodified' => 'required|date',
        ]);

        $score = Score::create($validated);
        return response()->json($score, 201);
    }

    public function show($id)
    {
        $score = Score::findOrFail($id);
        return response()->json($score);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'reservationid' => 'required|integer',
            'points' => 'required|integer',
            'round' => 'required|integer',
            'isactive' => 'required|boolean',
            'note' => 'nullable|string|max:255',
            'datecreated' => 'required|date',
            'datemodified' => 'required|date',
        ]);

        $score = Score::findOrFail($id);
        $score->update($validated);
        return response()->json($score);
    }

    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();
        return response()->json(null, 204);
    }
}
