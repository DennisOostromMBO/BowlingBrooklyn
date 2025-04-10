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
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'infix' => 'nullable|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'date_of_birth' => 'required|date|after_or_equal:1900-01-01|before:today',
            'street_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'house_number' => 'required|regex:/^\d+$/|digits_between:1,4',
            'addition' => 'nullable|string|max:8',
            'postal_code' => 'required|regex:/^[0-9]{4}[A-Z]{2}$/',
            'city' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'phone' => 'required|regex:/^06\d{8}$/',
            'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|not_regex:/xn--/'
        ], [
            'first_name.required' => 'First name is required',
            'first_name.regex' => 'First name is invalid',
            'infix.regex' => 'Infix is invalid',
            'last_name.required' => 'Last name is required',
            'last_name.regex' => 'Last name is invalid',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.date' => 'Date of birth is invalid',
            'date_of_birth.after_or_equal' => 'Date of birth is invalid',
            'date_of_birth.before' => 'Date of birth is invalid',
            'street_name.required' => 'Street name is required',
            'street_name.regex' => 'Street name is invalid',
            'house_number.required' => 'House number is required',
            'house_number.regex' => 'House number must be numeric',
            'postal_code.required' => 'Postal code is required',
            'postal_code.regex' => 'Postal code is invalid',
            'city.required' => 'City is required',
            'city.regex' => 'City name is invalid',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number is invalid',
            'email.required' => 'Email address is required',
            'email.email' => 'Email address is invalid',
            'email.regex' => 'Email address format is invalid'
        ]);

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
            'first_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'infix' => 'nullable|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'date_of_birth' => 'required|date|after_or_equal:1900-01-01|before:today',
            'street_name' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'house_number' => 'required|regex:/^\d+$/|digits_between:1,4',
            'addition' => 'nullable|string|max:8',
            'postal_code' => 'required|regex:/^[0-9]{4}[A-Z]{2}$/',
            'city' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\- ]+$/u',
            'phone' => 'required|regex:/^06\d{8}$/',
            'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|not_regex:/xn--/'
        ], [
            'first_name.required' => 'First name is required',
            'first_name.regex' => 'First name is invalid',
            'infix.regex' => 'Infix is invalid',
            'last_name.required' => 'Last name is required',
            'last_name.regex' => 'Last name is invalid',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.date' => 'Date of birth is invalid',
            'date_of_birth.after_or_equal' => 'Date of birth is invalid',
            'date_of_birth.before' => 'Date of birth is invalid',
            'street_name.required' => 'Street name is required',
            'street_name.regex' => 'Street name is invalid',
            'house_number.required' => 'House number is required',
            'house_number.regex' => 'House number must be numeric',
            'postal_code.required' => 'Postal code is required',
            'postal_code.regex' => 'Postal code is invalid',
            'city.required' => 'City is required',
            'city.regex' => 'City name is invalid',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number is invalid',
            'email.required' => 'Email address is required',
            'email.email' => 'Email address is invalid',
            'email.regex' => 'Email address format is invalid'
        ]);

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

        DB::select('CALL updateCustomer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
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
