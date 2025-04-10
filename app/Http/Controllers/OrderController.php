<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
            $orders = Order::all();
            return view('Order.Index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerid' => 'required|integer',
            'totalamount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'ispaid' => 'required|boolean',
            'note' => 'nullable|string|max:255',
            'datecreated' => 'required|date',
            'datemodified' => 'required|date',
        ]);

        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customerid' => 'required|integer',
            'totalamount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'ispaid' => 'required|boolean',
            'note' => 'nullable|string|max:255',
            'datecreated' => 'required|date',
            'datemodified' => 'required|date',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);
        
        return redirect()->route('orders.index')->with('success', 'Order is updated');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Prevent deletion if the status is "send"
        if ($order->status === 'send') {
            return redirect()->route('orders.index')->with('error', 'Orders that are already send cant be deleted.');
        }
    
        $order->delete();
    
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
    public function edit($id)
{
    $order = Order::findOrFail($id); // Fetch the order by ID
    return view('Order.edit', compact('order')); // Pass the order to the edit view
}
    
}
