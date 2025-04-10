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

    <!-- Orders Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Orders List</h1>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">alley Nummber</th>
                    <th class="border border-gray-700 px-4 py-2">Image</th>
                    <th class="border border-gray-700 px-4 py-2">Total Amount</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">{{ $order->bowling_alleyid }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->product }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->total_price }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <button class="edit bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
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
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>