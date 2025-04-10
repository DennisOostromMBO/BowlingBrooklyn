<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        @if ($errors->has('email'))
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg text-lg mb-8 text-center font-semibold">
                {{ $errors->first('email') }}
            </div>
        @endif

        <h1 class="text-4xl font-bold text-center mb-8">Create New Customer</h1>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            <form method="POST" action="/customers" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Infix</label>
                        <input type="text" name="infix" value="{{ old('infix') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Street Name</label>
                        <input type="text" name="street_name" value="{{ old('street_name') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium">House Number</label>
                            <input type="text" name="house_number" value="{{ old('house_number') }}" 
                                class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Addition</label>
                            <input type="text" name="addition" value="{{ old('addition') }}" 
                                class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" value="{{ old('city') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2 @error('email') border-red-500 @enderror">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="/customers" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Customer</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
