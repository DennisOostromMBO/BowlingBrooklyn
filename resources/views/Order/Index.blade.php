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

    <!-- Orders Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Orders List</h1>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">Customer ID</th>
                    <th class="border border-gray-700 px-4 py-2">Total Amount</th>
                    <th class="border border-gray-700 px-4 py-2">Status</th>
                    <th class="border border-gray-700 px-4 py-2">Is Paid</th>
                    <th class="border border-gray-700 px-4 py-2">Note</th>
                    <th class="border border-gray-700 px-4 py-2">Date Created</th>
                    <th class="border border-gray-700 px-4 py-2">Date Modified</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">{{ $order->customerid }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->totalamount }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->status }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->ispaid ? 'Yes' : 'No' }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->note }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->datecreated }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $order->datemodified }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <button class="edit bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                            <button class="delete bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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