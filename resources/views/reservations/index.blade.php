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

    <!-- Success Message -->
    @if (session('success'))
        <div id="success-message" class="bg-green-500 text-white text-center py-2 px-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Reservations Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Reservations</h1>

        @if ($reservations->isEmpty())
            <!-- No Reservations Message -->
            <p class="text-center text-gray-400">There are no reservations booked.</p>
        @else
            <table class="w-full border-collapse bg-gray-800 text-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-700 px-4 py-2">User</th>
                        <th class="border border-gray-700 px-4 py-2">Ally Number</th>
                        <th class="border border-gray-700 px-4 py-2">Number of Persons</th>
                        <th class="border border-gray-700 px-4 py-2">Reservation Date</th>
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
                        <td class="border border-gray-700 px-4 py-2">{{ $reservation->reservation_date }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $reservation->isactive ? 'Yes' : 'No' }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $reservation->note }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <!-- Edit Button -->
                            <button class="edit" onclick="window.location='{{ route('reservations.edit', $reservation->id) }}'">Edit</button>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="delete {{ \Carbon\Carbon::parse($reservation->reservation_date)->isPast() ? 'bg-gray-500 cursor-not-allowed' : '' }}" 
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->isPast() ? 'disabled' : '' }}
                                    onclick="return confirm('Are you sure you want to delete this reservation?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination and Create Button -->
            <div class="flex justify-between items-center mt-4">
                <!-- Create Reservation Button -->
                <a href="{{ route('reservations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Create Reservation
                </a>
                <!-- Pagination Links -->
                <div class="pagination-links">
                    {{ $reservations->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>

    <!-- Auto-hide Success Message -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>
</body>
</html>