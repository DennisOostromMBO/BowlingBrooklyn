<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling Brooklyn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2A2A40] text-[#E8E8F0]">
    <!-- Navigation Bar -->
    <x-navbar />

    <!-- Welcome Content -->
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
    <section class="py-20 bg-[#2A2A40] text-[#C0C0C0]">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#FFD700]">Why Choose Us?</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border border-[#FFD700]">
                    <h3 class="text-xl font-bold text-[#FFD700]">State-of-the-Art Lanes</h3>
                    <p class="mt-4 text-[#E0E0E0]">Experience the best bowling lanes in Brooklyn with cutting-edge technology.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border border-[#FFD700]">
                    <h3 class="text-xl font-bold text-[#FFD700]">Family-Friendly Atmosphere</h3>
                    <p class="mt-4 text-[#E0E0E0]">Bring your family and friends for a fun-filled day of bowling and entertainment.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border border-[#FFD700]">
                    <h3 class="text-xl font-bold text-[#FFD700]">Delicious Snacks & Drinks</h3>
                    <p class="mt-4 text-[#E0E0E0]">Enjoy a variety of snacks and beverages while you bowl.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bowling Fun Facts Section -->
    <section class="py-20 bg-[#1E1E2F] text-[#C0C0C0]">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#FFD700]">Did You Know?</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-6 bg-[#2A2A40] rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#FFD700]">Bowling is Ancient!</h3>
                    <p class="mt-4">Bowling dates back to ancient Egypt, with evidence of a game similar to bowling found in a child’s grave from 5200 BC.</p>
                </div>
                <div class="p-6 bg-[#2A2A40] rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#FFD700]">Perfect Game</h3>
                    <p class="mt-4">A perfect game in bowling is a score of 300, achieved by rolling 12 strikes in a row!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-[#2A2A40] text-[#C0C0C0]">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#FFD700]">What Our Customers Say</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border-l-4 border-[#FFD700]">
                    <p class="italic">"The best bowling experience I've ever had! The lanes are top-notch and the staff is super friendly."</p>
                    <p class="mt-4 font-bold">- Alex J.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border-l-4 border-[#FFD700]">
                    <p class="italic">"A great place to hang out with friends and family. Highly recommend their snacks too!"</p>
                    <p class="mt-4 font-bold">- Maria K.</p>
                </div>
                <div class="p-6 bg-[#1E1E2F] rounded-lg shadow-lg border-l-4 border-[#FFD700]">
                    <p class="italic">"Bowling Brooklyn is my go-to spot for weekend fun. Love the atmosphere!"</p>
                    <p class="mt-4 font-bold">- Chris P.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Light Beam -->
    <div class="light-beam"></div>

    <!-- Footer -->
    <x-footer />
</body>
</html>
