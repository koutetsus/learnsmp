<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Latihan Soal/Quiz</h1>
    </x-slot>

    <div class="py-6">
        <!-- Table to display quizzes -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quiz->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quiz->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $quiz->mataPelajaran ? $quiz->mataPelajaran->name : 'No Subject' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @can('detail-quiz')
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Lihat</a>
                            @endcan
                            <a href="{{ route('quizzes.take', $quiz->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Kerjakan Quiz</a>
                            @can( 'quiz-delete',)

                                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline-blocks">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

         {{-- Check if the user has permission to create Materi --}}
    @can('quiz-create')

        <!-- Button to create a new quiz -->
        <a href="{{ route('quizzes.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
            Tambah Quiz
        </a>
    @endcan

    </div>
</x-app-layout>
