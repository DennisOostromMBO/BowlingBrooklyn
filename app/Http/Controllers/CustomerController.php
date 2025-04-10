<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::select('CALL getAllCustomers()');
        $page = request()->get('page', 1);
        $perPage = 5;
        
        $pagedData = array_slice($customers, ($page - 1) * $perPage, $perPage);
        
        $customers = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            count($customers),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
        
        return view('customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Check if email exists
        $emailExists = DB::select('SELECT COUNT(*) as count FROM users WHERE email = ?', [$request->email])[0]->count > 0;
        
        if ($emailExists) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'This email address is already associated with a customer.']);
        }

        // Check if phone exists
        $phoneExists = DB::select('SELECT COUNT(*) as count FROM users WHERE phone = ?', [$request->phone])[0]->count > 0;
        
        if ($phoneExists) {
            return back()
                ->withInput()
                ->withErrors(['phone' => 'This phone number is already associated with a customer.']);
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
        // Check if email exists for other customers
        $emailExists = DB::select('SELECT COUNT(*) as count FROM users u 
            INNER JOIN persons p ON u.person_id = p.id 
            INNER JOIN customers c ON p.id = c.persons_id 
            WHERE u.email = ? AND c.id != ?', 
            [$request->email, $id])[0]->count > 0;
        
        if ($emailExists) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'This email address is already associated with another customer.']);
        }

        // Check if phone exists for other customers
        $phoneExists = DB::select('SELECT COUNT(*) as count FROM users u 
            INNER JOIN persons p ON u.person_id = p.id 
            INNER JOIN customers c ON p.id = c.persons_id 
            WHERE u.phone = ? AND c.id != ?', 
            [$request->phone, $id])[0]->count > 0;
        
        if ($phoneExists) {
            return back()
                ->withInput()
                ->withErrors(['phone' => 'This phone number is already associated with another customer.']);
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

        DB::select('CALL updateCustomer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $validatedData['first_name'],
            $request->infix,
            $validatedData['last_name'],
            $validatedData['date_of_birth'],  // Added date_of_birth parameter
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
        // Check if customer has reservations
        $customer = DB::select('CALL getCustomerById(?)', [$id])[0];
        if (!$customer->has_reservations) {
            return back()->with('error', 'Cannot delete customer without reservations.');
        }

        DB::select('CALL deleteCustomer(?)', [$id]);
        return redirect('/customers')->with('success', 'Customer deleted successfully');
    }
}
