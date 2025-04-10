<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <!-- Reservations Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Reservations</h1>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">User</th>
                    <th class="border border-gray-700 px-4 py-2">Ally Number</th>
                    <th class="border border-gray-700 px-4 py-2">Number of Persons</th>
                    <th class="border border-gray-700 px-4 py-2">Active</th>
                    <th class="border border-gray-700 px-4 py-2">Note</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr class="hover:bg-gray-700">
                    <td class="border border-gray-700 px-4 py-2">{{ $reservation->user->name }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $reservation->ally_number }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $reservation->number_of_persons }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $reservation->isactive ? 'Yes' : 'No' }}</td>
                    <td class="border border-gray-700 px-4 py-2">{{ $reservation->note }}</td>
                    <td class="border border-gray-700 px-4 py-2">
                        <button class="edit">Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
                @endforeach
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