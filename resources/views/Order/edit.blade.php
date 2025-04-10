<!-- filepath: c:\school2024-05\Project\BowlingBrooklyn\resources\views\Order\Edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Edit Order</h1>
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="product" class="block text-sm font-medium">Product</label>
                <input type="text" name="product" id="product" value="{{ $order->product }}" class="w-full px-4 py-2 rounded bg-gray-800 text-gray-200">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 rounded bg-gray-800 text-gray-200">
                    <option value="send" {{ $order->status === 'send' ? 'selected' : '' }}>Send</option>
                    <option value="making" {{ $order->status === 'making' ? 'selected' : '' }}>Making</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
        </form>
    </div>
</body>
</html>