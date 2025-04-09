<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling Brooklyn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navigation Bar -->
    <nav class="navbar bg-gray-900 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Bowling Brooklyn</a>
            <div class="space-x-4">
                <a href="/about" class="hover:text-blue-400">About</a>
                <a href="/lanes" class="hover:text-blue-400">Lanes</a>
                <a href="/contact" class="hover:text-blue-400">Contact</a>
                <a href="/example" class="hover:text-blue-400">Example</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-bold">Welcome to Bowling Brooklyn</h1>
            <p class="mt-4 text-lg">Your ultimate destination for fun and bowling in Brooklyn!</p>
            <div class="mt-8 space-x-4">
                <a href="/book" class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-gray-200">Book a Lane</a>
                <a href="/learn-more" class="px-6 py-3 bg-gray-800 text-white font-bold rounded-lg shadow-lg hover:bg-gray-700">Learn More</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800">Why Choose Us?</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600">State-of-the-Art Lanes</h3>
                    <p class="mt-4 text-gray-600">Experience the best bowling lanes in Brooklyn with cutting-edge technology.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600">Family-Friendly Atmosphere</h3>
                    <p class="mt-4 text-gray-600">Bring your family and friends for a fun-filled day of bowling and entertainment.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600">Delicious Snacks & Drinks</h3>
                    <p class="mt-4 text-gray-600">Enjoy a variety of snacks and beverages while you bowl.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
