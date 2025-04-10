<nav class="navbar bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-2xl font-bold">Bowling Brooklyn</a>
        <div class="space-x-4">
            <a href="/about" class="hover:text-blue-400">About</a>
            <a href="/lanes" class="hover:text-blue-400">Lanes</a>
            <a href="/contact" class="hover:text-blue-400">Contact</a>
            <a href="/example" class="hover:text-blue-400">Example</a>
            <a href="{{ route('scores.index') }}" class="hover:text-blue-400">Scores</a>
        </div>
    </div>
</nav>
