<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Create Reservation</h1>

        <form action="{{ route('reservations.store') }}" method="POST" class="max-w-lg mx-auto bg-gray-800 p-6 rounded">
            @csrf

            <!-- User Dropdown -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium">User</label>
                <select name="user_id" id="user_id" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
                    <option value="" disabled selected>Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ally Number -->
            <div class="mb-4">
                <label for="ally_number" class="block text-sm font-medium">Ally Number</label>
                <input type="number" name="ally_number" id="ally_number" value="{{ old('ally_number') }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
                @error('ally_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Number of Persons -->
            <div class="mb-4">
                <label for="number_of_persons" class="block text-sm font-medium">Number of Persons</label>
                <input type="number" name="number_of_persons" id="number_of_persons" value="{{ old('number_of_persons') }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
                @error('number_of_persons')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reservation Date -->
            <div class="mb-4">
                <label for="reservation_date" class="block text-sm font-medium">Reservation Date</label>
                <input type="date" name="reservation_date" id="reservation_date" value="{{ old('reservation_date') }}" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">
                @error('reservation_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Note -->
            <div class="mb-4">
                <label for="note" class="block text-sm font-medium">Note</label>
                <textarea name="note" id="note" rows="4" class="w-full mt-1 p-2 bg-gray-700 text-white rounded">{{ old('note') }}</textarea>
                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Create Reservation
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