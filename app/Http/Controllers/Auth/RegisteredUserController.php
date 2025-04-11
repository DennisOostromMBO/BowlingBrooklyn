<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'], // Validatie voor telefoonnummer toegevoegd
        ]);

        // Call the stored procedure to create the user
        DB::statement('CALL spCreateUser(?, ?, ?, ?, ?, ?, ?)', [
            $request->first_name,
            $request->middle_name,
            $request->last_name,
            $request->email,
            Hash::make($request->password),
            $request->date_of_birth,
            $request->phone, // Telefoonnummer toegevoegd
        ]);

        // Retrieve the newly created user
        $user = User::where('email', $request->email)->first();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}