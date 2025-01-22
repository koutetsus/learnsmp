<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Nilai Siswa</h1>
    </x-slot>

    <div class="space-y-6">
        @foreach($scores as $subjectName => $quizzes)
            <div class="bg-white shadow rounded-lg p-4 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $subjectName }}</h2>
                <div class="mt-4">
                    @foreach($quizzes as $quizTitle => $quizScores)
                        <div class="bg-gray-100 p-4 rounded-lg mb-4 dark:bg-gray-700">
                            <h3 class="text-md font-semibold text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">{{ $quizTitle }}</h3>
                            <table class="min-w-full divide-y divide-gray-200 mt-2">
                                <thead>
                                    <tr>
                                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Nama Siswa</th>
                                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                                    @foreach($quizScores as $score)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $score->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $score->percentage_score }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
