<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200">
    <x-navbar />

    <!-- Example Content -->
    <div class="container mx-auto py-20">
        <h1 class="text-4xl font-bold text-center mb-8">Example Page</h1>
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">ID</th>
                    <th class="border border-gray-700 px-4 py-2">Name</th>
                    <th class="border border-gray-700 px-4 py-2">Email</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-700">
                    <td class="border border-gray-700 px-4 py-2">1</td>
                    <td class="border border-gray-700 px-4 py-2">John Doe</td>
                    <td class="border border-gray-700 px-4 py-2">john@example.com</td>
                    <td class="border border-gray-700 px-4 py-2">
                        <button class="edit">Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-700">
                    <td class="border border-gray-700 px-4 py-2">2</td>
                    <td class="border border-gray-700 px-4 py-2">Jane Smith</td>
                    <td class="border border-gray-700 px-4 py-2">jane@example.com</td>
                    <td class="border border-gray-700 px-4 py-2">
                        <button class="edit">Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Bowling Brooklyn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
