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
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
