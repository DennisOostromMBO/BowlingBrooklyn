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
}
