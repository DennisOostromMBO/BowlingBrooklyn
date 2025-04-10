<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Noto+Color+Emoji&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-center">Customers</h1>
            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ➕ Add New Customer
            </a>
        </div>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">Name</th>
                    <th class="border border-gray-700 px-4 py-2">Address</th>
                    <th class="border border-gray-700 px-4 py-2">Customer Number</th>
                    <th class="border border-gray-700 px-4 py-2">Phone</th>
                    <th class="border border-gray-700 px-4 py-2">Email</th>
                    <th class="border border-gray-700 px-4 py-2">Edit</th>
                    <th class="border border-gray-700 px-4 py-2">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">
                            {{ $customer->first_name }} {{ $customer->infix }} {{ $customer->last_name }}
                        </td>
                        <td class="border border-gray-700 px-4 py-2">
                            {{ $customer->street_name }} {{ $customer->house_number }}{{ $customer->addition }}<br>
                            {{ $customer->postal_code }} {{ $customer->city }}
                        </td>
                        <td class="border border-gray-700 px-4 py-2">{{ $customer->customer_number }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $customer->phone }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $customer->email }}</td>
                        <td class="border border-gray-700 px-4 py-2 text-center">
                            <a href="/customers/{{ $customer->id }}/edit" class="text-blue-500 hover:text-blue-700 text-xl">✏️</a>
                        </td>
                        <td class="border border-gray-700 px-4 py-2 text-center">
                            <form method="POST" action="/customers/{{ $customer->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" 
                                    class="text-red-500 hover:text-red-700 text-xl">❌</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>