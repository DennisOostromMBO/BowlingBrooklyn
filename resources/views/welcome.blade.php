<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling Brooklyn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#121212] text-[#E0E0E0]">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Bowling Brooklyn</a>
            <div class="space-x-4">
                <a href="/about">About</a>
                <a href="/lanes">Lanes</a>
                <a href="/contact">Contact</a>
                <a href="/example">Example</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-[#1E1E2F] text-[#C0C0C0] py-20 relative">
        <div class="container mx-auto text-center relative z-10">
            <h1 class="text-5xl font-bold">Welcome to Bowling Brooklyn</h1>
            <p class="mt-4 text-lg">Your ultimate destination for fun and bowling in Brooklyn!</p>
            <div class="mt-8 space-x-4">
                <a href="/book" class="px-6 py-3 bg-[#FFD700] text-[#1E1E2F] font-bold rounded-lg shadow-lg hover:bg-[#FF4500]">Book a Lane</a>
                <a href="/learn-more" class="px-6 py-3 bg-[#4B0082] text-white font-bold rounded-lg shadow-lg hover:bg-[#6A0DAD]">Learn More</a>
            </div>
        </div>
        <div class="absolute inset-0">
            <img src="{{ asset('img/bowling.png') }}" alt="Bowling Background" class="w-full h-full object-cover opacity-30">
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-20 bg-[#121212]">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#FFD700]">Why Choose Us?</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#FFD700]">State-of-the-Art Lanes</h3>
                    <p class="mt-4 text-[#E0E0E0]">Experience the best bowling lanes in Brooklyn with cutting-edge technology.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#FFD700]">Family-Friendly Atmosphere</h3>
                    <p class="mt-4 text-[#E0E0E0]">Bring your family and friends for a fun-filled day of bowling and entertainment.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#FFD700]">Delicious Snacks & Drinks</h3>
                    <p class="mt-4 text-[#E0E0E0]">Enjoy a variety of snacks and beverages while you bowl.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1E1E2F] text-[#FFD700] py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
