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
                <label for="product" class="block text-sm font-medium mb-2">Product</label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach(['Pizza', 'Nachos', 'Drinks Package', 'Burger', 'VIP Package', 'Wings', 'Fries', 'Snack Platter', 'Premium Drinks', 'Kids Menu'] as $product)
                        <label class="cursor-pointer">
                            <input type="radio" name="product" value="{{ $product }}" {{ old('product', $order->product) == $product ? 'checked' : '' }} class="hidden">
                            <div class="border-2 border-gray-700 rounded-lg p-2 hover:border-blue-500 {{ old('product', $order->product) == $product ? 'border-blue-500' : '' }}">
                                <img src="/images/products/{{ strtolower(str_replace(' ', '_', $product)) }}.jpg" alt="{{ $product }}" class="w-full h-32 object-cover rounded">
                                <p class="text-center mt-2">{{ $product }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productInputs = document.querySelectorAll('input[name="product"]');
            const priceDisplay = document.createElement('p');
            priceDisplay.classList.add('text-lg', 'font-bold', 'mt-4');
            document.querySelector('form').insertBefore(priceDisplay, document.querySelector('button'));

            const productPrices = @json($productPrices); // Use product prices passed from the controller

            const updatePrice = () => {
                const selectedProduct = document.querySelector('input[name="product"]:checked');
                if (selectedProduct) {
                    priceDisplay.textContent = `Price: $${productPrices[selectedProduct.value].toFixed(2)}`;
                } else {
                    priceDisplay.textContent = '';
                }
            };

            productInputs.forEach(input => {
                input.addEventListener('change', updatePrice);
            });

            updatePrice(); // Initialize price on page load
        });
    </script>
</body>
</html>