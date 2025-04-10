<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::paginate(5); // Paginate with 5 items per page
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $users = DB::table('users')->get(); // Retrieve all users for the dropdown
        return view('reservations.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ally_number' => [
                'required',
                'integer',
                'unique:reservations,ally_number', // Ensure ally_number is unique
            ],
            'number_of_persons' => 'required|integer',
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ensure reservation_date is not in the past
            ],
            'note' => 'nullable|string',
        ]);

        DB::statement('CALL spCreateReservation(?, ?, ?, ?, ?)', [
            $request->user_id,
            $request->ally_number,
            $request->number_of_persons,
            $request->reservation_date,
            $request->note,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id); // Retrieve the reservation by ID
        return view('reservations.edit', compact('reservation')); // Pass the reservation to the edit view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ally_number' => [
                'required',
                'integer',
                'unique:reservations,ally_number,' . $id, // Ensure ally_number is unique, excluding the current reservation
            ],
            'number_of_persons' => 'required|integer',
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ensure reservation_date is not in the past
            ],
            'isactive' => 'required|boolean',
            'note' => 'nullable|string',
        ]);

        DB::statement('CALL spUpdateReservation(?, ?, ?, ?, ?, ?)', [
            $id,
            $request->ally_number,
            $request->number_of_persons,
            $request->reservation_date,
            $request->isactive,
            $request->note,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        DB::statement('CALL spDeleteReservation(?)', [$id]);

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
