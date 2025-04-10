<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Create New Order</h1>


        <form action="{{ route('orders.store') }}" method="POST" class="max-w-lg mx-auto bg-gray-800 p-6 rounded">
            @csrf

            <div class="mb-4">
                <label for="bowling_alleyid" class="block text-sm font-medium">Bowling Alley Number</label>
                <input type="number" name="bowling_alleyid" id="bowling_alleyid" class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded" max="10">
                @error('bowling_alleyid')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="product" class="block text-sm font-medium">Product</label>
                <select name="product" id="product" class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded" >
                    <option value="" disabled selected>Select a product</option>
                    @foreach ($productPrices as $product => $price)
                        <option value="{{ $product }}">{{ $product }} - ${{ number_format($price, 2) }}</option>
                    @endforeach
                </select>
                @error('product')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="note" class="block text-sm font-medium">Note</label>
                <textarea name="note" id="note" rows="3" class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Order</button>
            </div>
        </form>
    </div>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>