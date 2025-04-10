<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::select('CALL getAllCustomers()');
        return view('customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // First check if email exists
        $emailExists = DB::select('SELECT COUNT(*) as count FROM users WHERE email = ?', [$request->email])[0]->count > 0;
        
        if ($emailExists) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'This email address is already associated with a customer.']);
        }

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'street_name' => 'required',
            'house_number' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        DB::select('CALL createCustomer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $validatedData['first_name'],
            $request->infix,
            $validatedData['last_name'],
            $validatedData['date_of_birth'],
            $validatedData['street_name'],
            $validatedData['house_number'],
            $request->addition,
            $validatedData['postal_code'],
            $validatedData['city'],
            $validatedData['phone'],
            $validatedData['email']
        ]);

        return redirect('/customers')->with('success', 'New customer created successfully');
    }

    public function edit($id)
    {
        $customer = DB::select('CALL getCustomerById(?)', [$id])[0];
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'street_name' => 'required',
            'house_number' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        DB::select('CALL updateCustomer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $validatedData['first_name'],
            $request->infix,
            $validatedData['last_name'],
            $validatedData['street_name'],
            $validatedData['house_number'],
            $request->addition,
            $validatedData['postal_code'],
            $validatedData['city'],
            $validatedData['phone'],
            $validatedData['email']
        ]);

        return redirect('/customers')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        DB::select('CALL deleteCustomer(?)', [$id]);
        return redirect('/customers')->with('success', 'Customer deleted successfully');
    }
}
