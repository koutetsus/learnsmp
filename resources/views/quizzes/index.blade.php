<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">All Quizzes</h1>
    </x-slot>

    <div class="py-6">
        <!-- Table to display quizzes -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quiz->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quiz->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $quiz->mataPelajaran ? $quiz->mataPelajaran->name : 'No Subject' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="{{ route('quizzes.take', $quiz->id) }}" class="ml-4 text-blue-600 hover:text-blue-900">Take Quiz</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Button to create a new quiz -->
        <a href="{{ route('quizzes.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
            Add New Quiz
        </a>
    </div>
</x-app-layout>
