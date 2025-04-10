<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Edit Reservation</h1>

        <!-- Display User -->
        <div class="max-w-lg mx-auto bg-gray-800 p-6 rounded mb-6">
            <p class="text-sm font-medium text-gray-400">Booked By:</p>
            <p class="text-lg font-bold text-white">{{ $reservation->user->name }}</p>
        </div>

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="max-w-lg mx-auto bg-gray-800 p-6 rounded">
            @csrf
            @method('PUT')

            <!-- Ally Number -->
            <div class="mb-4">
                <label for="ally_number" class="block text-sm font-medium">Ally Number</label>
                <input type="number" name="ally_number" id="ally_number" value="{{ $reservation->ally_number }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Number of Persons -->
            <div class="mb-4">
                <label for="number_of_persons" class="block text-sm font-medium">Number of Persons</label>
                <input type="number" name="number_of_persons" id="number_of_persons" value="{{ $reservation->number_of_persons }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Reservation Date -->
            <div class="mb-4">
                <label for="reservation_date" class="block text-sm font-medium">Reservation Date</label>
                <input type="date" name="reservation_date" id="reservation_date" value="{{ $reservation->reservation_date }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
            </div>

            <!-- Active -->
            <div class="mb-4">
                <label for="isactive" class="block text-sm font-medium">Active</label>
                <select name="isactive" id="isactive" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
                    <option value="1" {{ $reservation->isactive ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$reservation->isactive ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <!-- Note -->
            <div class="mb-4">
                <label for="note" class="block text-sm font-medium">Note</label>
                <textarea name="note" id="note" rows="4" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">{{ $reservation->note }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>