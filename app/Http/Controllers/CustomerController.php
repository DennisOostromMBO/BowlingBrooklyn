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
}
