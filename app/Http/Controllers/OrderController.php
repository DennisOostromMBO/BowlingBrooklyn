<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderByRaw("FIELD(status, 'pending', 'making', 'send')")
                       ->orderBy('id')
                       ->paginate(10); // Paginate orders with 10 per page
        return view('Order.Index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bowling_alleyid' => 'required|integer',
            'product' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
        ]);

        $order = new Order();
        $order->bowling_alleyid = $validated['bowling_alleyid'];
        $order->product = $validated['product'];
        $order->note = $validated['note'] ?? null;
        $order->status = (string) 'pending'; // Default status as string
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        // Redirect to the index page with a success message
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
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

        // Define product prices
        $productPrices = [
            'Pizza' => 10.00,
            'Nachos' => 8.00,
            'Drinks Package' => 15.00,
            'Burger' => 12.00,
            'VIP Package' => 50.00,
            'Wings' => 9.00,
            'Fries' => 5.00,
            'Snack Platter' => 20.00,
            'Premium Drinks' => 25.00,
            'Kids Menu' => 7.00
        ];

        return view('Order.edit', compact('order', 'productPrices')); // Pass the order and product prices to the edit view
    }

    public function create()
    {
        // Define product prices
        $productPrices = [
            'Pizza' => 10.00,
            'Nachos' => 8.00,
            'Drinks Package' => 15.00,
            'Burger' => 12.00,
            'VIP Package' => 50.00,
            'Wings' => 9.00,
            'Fries' => 5.00,
            'Snack Platter' => 20.00,
            'Premium Drinks' => 25.00,
            'Kids Menu' => 7.00
        ];

        return view('Order.create', compact('productPrices'));
    }
}
