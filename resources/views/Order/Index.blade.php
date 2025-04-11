<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        @if (session('success'))
            <div class="bg-green-500 text-white text-center py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
    <div class="bg-red-500 text-white text-center py-2 mb-4 rounded">
        {{ session('error') }}
    </div>
@endif

    <!-- Orders Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Orders List</h1>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">alley Nummber</th>
                    <th class="border border-gray-700 px-4 py-2">Producten</th>
                    <th class="border border-gray-700 px-4 py-2">Status</th>
                    <th class="border border-gray-700 px-4 py-2">Total Amount</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>

            @php
                $sortedOrders = $orders->sortBy(function ($order) {
                    return [
                        $order->status === 'pending' ? 0 : ($order->status === 'making' ? 1 : 2),
                        $order->id
                    ];
                });
            @endphp

            <tbody>
                @forelse ($sortedOrders as $order)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">{{ $order->bowling_alleyid }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->product }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->status }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            @php
                                $prices = [
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
                                $price = $prices[$order->product] ?? 0.00;
                            @endphp
                            {{ number_format($price, 2) }}
                        </td>
                        <td class="border border-gray-700 px-4 py-2">
                            @if ($order->status !== 'send')
                                <a href="{{ route('orders.edit', $order->id) }}" class="edit bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                            @else
                                <span class="bg-gray-500 text-white px-2 py-1 rounded cursor-not-allowed">Edit</span>
                            @endif
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center border border-gray-700 px-4 py-2">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->links() }} <!-- Add pagination links -->
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Order here</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>