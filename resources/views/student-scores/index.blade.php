<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Student Scores</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="mb-4">
            <a href="{{ route('student-scores.export') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Export as PDF
            </a>

        </div>

        <!-- Existing content for displaying scores -->
        @foreach($scores as $subjectName => $quizzes)
            <div x-data="{ open: false }" class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold flex items-center cursor-pointer" @click="open = !open">
                    <span>{{ $subjectName }}</span>
                    <svg x-show="!open" class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <svg x-show="open" class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </h2>
                <div x-show="open" class="mt-4 space-y-4">
                    @foreach($quizzes as $quizTitle => $quizScores)
                        <div x-data="{ open: false }" class="bg-gray-100 p-4 rounded-lg">
                            <h3 class="text-md font-semibold flex items-center cursor-pointer" @click="open = !open">
                                <span>{{ $quizTitle }}</span>
                                <svg x-show="!open" class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <svg x-show="open" class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </h3>
                            <div x-show="open" class="mt-2">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($quizScores as $score)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $score->user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $score->score }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Include Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
</x-app-layout>
