<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'E-Learning') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition duration-500">

    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo and Branding -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('views/components/image/logo.png') }}" class="h-8" alt="School Logo">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">School E-Learning</span>
            </a>
            <div class="flex md:order-2 space-x-3">
                <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Login
                </a>
                <a href="{{ route('register') }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">Welcome to E-Learning Platform</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">An online platform for all your learning needs.</p>

        <!-- Call to Action Buttons -->
        <div class="flex space-x-4">
            <a href="{{ route('dashboard') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-lg px-6 py-3">Start Learning</a>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium rounded-lg text-lg px-6 py-3">Learn More</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2024 School E-Learning. All Rights Reserved.</p>
    </footer>
</body>
</html>
