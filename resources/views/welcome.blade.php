<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'E-Learning') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen">


    <!-- Slider -->
    <div x-data="{
        activeSlide: 0,
        images: [
            '{{ asset('storage/images/smpn-1.jpg') }}',
            '{{ asset('storage/images/smpn-2.jpg') }}',
            '{{ asset('storage/images/smpn-3.jpg') }}'
        ]
    }" class="relative w-full max-w-6xl mx-auto mt-4">

    <!-- Main Image -->
    <div class="overflow-hidden rounded-lg">
        <img :src="images[activeSlide]" :alt="'Image ' + (activeSlide + 1)" class="w-full">
    </div>

    <!-- Icons Below (Dots) -->
    <div class="flex justify-center space-x-2 mt-4">
        <template x-for="(image, index) in images" :key="index">
            <button
                :class="{ 'bg-blue-500': activeSlide === index, 'bg-gray-300': activeSlide !== index }"
                @click="activeSlide = index"
                class="w-4 h-4 rounded-full cursor-pointer">
            </button>
        </template>
    </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('storage/images/smpn2kts.jpg') }}" class="h-12" alt="School Logo">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">E-Learning SMPN 2 Kartasura</span>
            </a>
            <div class="flex md:order-2 space-x-3">
                <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Login
                </a>
                <a href="{{ route('register') }}" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">Selamat Datang Di E-learning SMPN 2 Kartasura</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">Website E-learning Khusus Untuk SMP Negeri 2 Kartasura</p>

        <!-- Call to Action Buttons -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('dashboard') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-lg px-6 py-3">Mulai</a>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium rounded-lg text-lg px-6 py-3">Pelajari Lebih Lanjut</a>
        </div>

        <!-- Visi dan Misi -->
        <div class="mt-10 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8 max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                <!-- Visi -->
                <div>
                    <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">Visi</h2>
                    <p class="text-gray-700 dark:text-gray-300">
                        Menciptakan generasi yang cerdas, berkarakter, dan berdaya saing melalui pembelajaran berbasis teknologi.
                    </p>
                </div>

                <!-- Misi -->
                <div>
                    <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">Misi</h2>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2 text-left">
                        <li>Menyediakan akses pembelajaran yang mudah, efektif, dan menyenangkan.</li>
                        <li>Memberikan fasilitas pendidikan berbasis teknologi yang inovatif.</li>
                        <li>Mendorong siswa untuk mengembangkan kreativitas dan kemampuan problem-solving.</li>
                        <li>Membangun komunitas pembelajaran yang inklusif dan kolaboratif.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2025 E-learning SMP Negeri 2 Kartasura, Sukoharjo, Jawa Tengah</p>
    </footer>



</body>
</html>
