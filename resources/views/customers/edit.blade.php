<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        @if ($errors->has('email') || $errors->has('phone'))
            <div class="space-y-4">
                @if ($errors->has('email'))
                    <div class="bg-red-500 text-white px-6 py-4 rounded-lg text-lg text-center font-semibold">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                @if ($errors->has('phone'))
                    <div class="bg-red-500 text-white px-6 py-4 rounded-lg text-lg text-center font-semibold">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
        @endif

        <h1 class="text-4xl font-bold text-center mb-8">Edit Customer</h1>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            <form method="POST" action="/customers/{{ $customer->id }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative mt-6">
                        @error('first_name')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('first_name') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('infix')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Infix</label>
                        <input type="text" name="infix" value="{{ old('infix', $customer->infix) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('infix') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('last_name')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('last_name') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('date_of_birth')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('date_of_birth') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Customer Number</label>
                        <input type="text" value="{{ $customer->customer_number }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 text-gray-900 px-3 py-2" readonly>
                    </div>
                    <div class="relative mt-6">
                        @error('street_name')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Street Name</label>
                        <input type="text" name="street_name" value="{{ old('street_name', $customer->street_name) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('street_name') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="relative mt-6">
                            @error('house_number')
                                <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                            @enderror
                            <label class="block text-sm font-medium mt-4">House Number</label>
                            <input type="text" name="house_number" value="{{ old('house_number', $customer->house_number) }}" 
                                class="mt-1 block w-full rounded bg-white border-gray-300 @error('house_number') border-red-500 @enderror text-gray-900 px-3 py-2">
                        </div>
                        <div class="relative mt-6">
                            @error('addition')
                                <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                            @enderror
                            <label class="block text-sm font-medium mt-4">Addition</label>
                            <input type="text" name="addition" value="{{ old('addition', $customer->addition) }}" 
                                class="mt-1 block w-full rounded bg-white border-gray-300 @error('addition') border-red-500 @enderror text-gray-900 px-3 py-2">
                        </div>
                    </div>
                    <div class="relative mt-6">
                        @error('postal_code')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $customer->postal_code) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('postal_code') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('city')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">City</label>
                        <input type="text" name="city" value="{{ old('city', $customer->city) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('city') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('phone')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('phone') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                    <div class="relative mt-6">
                        @error('email')
                            <div class="absolute -top-7 left-0 text-red-600 text-sm font-semibold">{{ $message }}</div>
                        @enderror
                        <label class="block text-sm font-medium mt-4">Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" 
                            class="mt-1 block w-full rounded bg-white border-gray-300 @error('email') border-red-500 @enderror text-gray-900 px-3 py-2">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="/customers" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
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
