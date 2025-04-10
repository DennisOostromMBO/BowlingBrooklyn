<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('scores')
            ->join('reservations', 'scores.reservation_id', '=', 'reservations.id')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->select('scores.*', 'users.name as user_name');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%$search%")
                  ->orWhere('scores.points', 'like', "%$search%")
                  ->orWhere('scores.team_name', 'like', "%$search%");
            });
        }

        // Order scores from lowest to highest
        $query->orderBy('scores.points', 'asc');

        $scores = $query->paginate(5);

        return view('scores.index', ['scores' => $scores]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|integer',
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0',
            'team_name' => 'nullable|string|max:255',
            'participant_names' => 'array', // Add validation for participant names
        ]);

        // Use custom team name if provided, otherwise generate from reservation
        $teamName = $validated['team_name'] ?? \DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->where('reservations.id', $validated['reservation_id'])
            ->value('users.name');

        // Calculate total points from registered participants
        $totalPoints = array_sum($validated['scores']);

        // Create a single score record with all teammate data
        $scoreData = [
            'reservation_id' => $validated['reservation_id'],
            'points' => $totalPoints,  // Will be updated with additional points later
            'round' => 1, // Assuming round 1 for simplicity
            'status' => 'In progress',
            'isactive' => true,
            'note' => null,
            'team_name' => $teamName, // No "Team" prefix - use clean name
            // Initialize all teammate fields to null
            'teammate1' => null,
            'teammate1_score' => null,
            'teammate2' => null,
            'teammate2_score' => null,
            'teammate3' => null,
            'teammate3_score' => null,
            'teammate4' => null,
            'teammate4_score' => null,
            'teammate5' => null,
            'teammate5_score' => null,
            'teammate6' => null,
            'teammate6_score' => null,
            'teammate7' => null,
            'teammate7_score' => null,
            'teammate8' => null,
            'teammate8_score' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Add registered teammates data
        $teammateIndex = 1;
        foreach ($validated['scores'] as $userId => $score) {
            if ($teammateIndex <= 8) {
                // Use participant names if provided, otherwise use user ID
                $name = isset($request->participant_names[$userId]) ? $request->participant_names[$userId] : "Player {$teammateIndex}";
                $scoreData["teammate{$teammateIndex}"] = $name;
                $scoreData["teammate{$teammateIndex}_score"] = $score;
                $teammateIndex++;
            }
        }

        // Add new members if space allows
        if (!empty($request->new_members)) {
            foreach ($request->new_members as $member) {
                if ($teammateIndex <= 8 && isset($member['name']) && isset($member['score'])) {
                    $scoreData["teammate{$teammateIndex}"] = $member['name'];
                    $scoreData["teammate{$teammateIndex}_score"] = $member['score'];
                    $totalPoints += (int)$member['score']; // Add to total points
                    $teammateIndex++;
                }
            }
        }

        // Update the total points to include new members
        $scoreData['points'] = $totalPoints;

        // Insert the complete score record
        \DB::table('scores')->insert($scoreData);

        return redirect()->route('scores.index')->with('success', 'Scores successfully saved.');
    }

    public function show($id)
    {
        $score = Score::findOrFail($id);
        return response()->json($score);
    }

    public function update(Request $request, $id)
    {
        // Fetch the score first
        $score = DB::table('scores')->where('id', $id)->first();

        // Check if status is confirmed - prevent editing
        if ($score && $score->status === 'Confirmed') {
            return redirect()->route('scores.index')
                ->with('error', 'Cannot edit a confirmed score.');
        }

        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'points' => 'required|integer',
            'round' => 'required|integer',
            'status' => 'required|in:In progress,Confirmed',
            'isactive' => 'required|boolean',
            'note' => 'nullable|string|max:255',
        ]);

        // Start with basic data
        $updateData = [
            'team_name' => $validated['team_name'],
            'points' => $validated['points'],
            'round' => $validated['round'],
            'status' => $validated['status'],
            'isactive' => $validated['isactive'],
            'note' => $validated['note'],
            'updated_at' => now(),
        ];

        // Initialize all teammate fields to their current values or null if being removed
        for ($i = 1; $i <= 8; $i++) {
            // By default, keep existing values
            $updateData["teammate{$i}"] = $score->{"teammate{$i}"};
            $updateData["teammate{$i}_score"] = $score->{"teammate{$i}_score"};
        }

        // First, clear all teammate fields that should be removed
        if ($request->has('remove_teammate')) {
            foreach ($request->remove_teammate as $index => $value) {
                $updateData["teammate{$index}"] = null;
                $updateData["teammate{$index}_score"] = null;
            }
        }

        // Then process all teammate fields that are submitted
        $totalPoints = 0;

        // Process existing and new teammates
        for ($i = 1; $i <= 8; $i++) {
            $memberName = $request->input("teammate{$i}");
            $memberScore = $request->input("teammate{$i}_score");

            // Skip removed teammates
            if ($request->has("remove_teammate.{$i}")) {
                continue;
            }

            if ($memberName && $memberScore !== null) {
                $updateData["teammate{$i}"] = $memberName;
                $updateData["teammate{$i}_score"] = $memberScore;
                $totalPoints += (int)$memberScore;
            }
        }

        // Calculate and update total points from team members
        $updateData['points'] = $totalPoints;

        // Update the score record
        DB::table('scores')->where('id', $id)->update($updateData);

        return redirect()->route('scores.index')->with('success', 'Score successfully updated.');
    }

    public function destroy($id)
    {
        // Fetch the score first
        $score = DB::table('scores')->where('id', $id)->first();

        // Check if status is confirmed - prevent deleting
        if ($score && $score->status === 'Confirmed') {
            return redirect()->route('scores.index')
                ->with('error', 'Cannot delete a confirmed score.');
        }

        DB::statement('CALL DeleteScore(?)', [$id]);
        return redirect()->route('scores.index')->with('success', 'Score successfully deleted.');
    }

    public function create(Request $request)
    {
        $reservations = \DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->select('reservations.id', 'users.name as user_name')
            ->get();

        $participants = [];
        $leaderName = null;

        if ($request->has('leader')) {
            $leaderId = $request->input('leader');

            // Fetch leader name
            $leaderName = \DB::table('reservations')
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->where('reservations.id', $leaderId)
                ->value('users.name');

            // Fetch participants for the selected leader
            $participants = \DB::table('reservations')
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->where('reservations.id', $leaderId)
                ->select('users.id', 'users.name')
                ->get();
        }

        return view('scores.create', [
            'reservations' => $reservations,
            'participants' => $participants,
            'leaderName' => $leaderName
        ]);
    }

    public function edit($id)
    {
        $score = DB::table('scores')->where('id', $id)->first();
        return view('scores.edit', ['score' => $score]);
    }
}
