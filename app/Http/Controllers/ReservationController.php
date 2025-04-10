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

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id); // Retrieve the reservation by ID
        return view('reservations.edit', compact('reservation')); // Pass the reservation to the edit view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ally_number' => 'required|integer',
            'number_of_persons' => 'required|integer',
            'reservation_date' => 'required|date',
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
