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
            'reservation_id' => 'required|integer|exists:reservations,id',
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0|max:300',
            'team_name' => 'nullable|string|max:255',
            'new_members' => 'array',
            'new_members.*.name' => 'required|string|max:255',
            'new_members.*.score' => 'required|integer|min:0|max:300',
        ], [
            'scores.*.max' => 'The score for a participant must not exceed 300.',
            'new_members.*.score.max' => 'The score of a teammate can be a maximum of 300.',
        ]);

        // Use custom team name if provided, otherwise generate from reservation
        $teamName = $validated['team_name'] ?? \DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->where('reservations.id', $validated['reservation_id'])
            ->value('users.name');

        // Calculate total points from registered participants
        $totalPoints = array_sum($validated['scores']);

        // Prepare the score data
        $scoreData = [
            'reservation_id' => $validated['reservation_id'],
            'points' => $totalPoints,
            'round' => 1,
            'status' => 'In progress',
            'isactive' => true,
            'note' => null,
            'team_name' => $teamName,
        ];

        // Add the team captain (first participant) as teammate1
        $teammateIndex = 1;
        $captainId = null;
        foreach ($validated['scores'] as $userId => $score) {
            if ($teammateIndex === 1) {
                $scoreData["teammate{$teammateIndex}"] = $request->input("participant_names.{$userId}");
                $scoreData["teammate{$teammateIndex}_score"] = $score;
                $captainId = $userId; // Store the captain's ID to skip later
                $teammateIndex++;
                break; // Only the first participant is the captain
            }
        }

        // Add other teammates to the score data, skipping the captain
        foreach ($validated['scores'] as $userId => $score) {
            if ($userId == $captainId) {
                continue; // Skip the captain
            }

            if ($teammateIndex <= 8) {
                $scoreData["teammate{$teammateIndex}"] = $request->input("participant_names.{$userId}");
                $scoreData["teammate{$teammateIndex}_score"] = $score;
                $teammateIndex++;
            }
        }

        // Add new members if space allows
        foreach ($validated['new_members'] as $newMember) {
            if ($teammateIndex <= 8) {
                $scoreData["teammate{$teammateIndex}"] = $newMember['name'];
                $scoreData["teammate{$teammateIndex}_score"] = $newMember['score'];
                $totalPoints += $newMember['score'];
                $teammateIndex++;
            }
        }

        // Update the total points
        $scoreData['points'] = $totalPoints;

        // Save the score
        \DB::table('scores')->insert($scoreData);

        return redirect()->route('scores.index')->with('success', 'Score saved successfully!');
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
