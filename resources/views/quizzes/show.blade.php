<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Detail : {{ $quiz->title }}</h1>
    </x-slot>

    <div class="py-6">
        <!-- Quiz Details -->
        <div class="mb-4">

            <p><strong>Judul :</strong> {{ $quiz->title }}</p>
            <p><strong>Deskripsi:</strong> {{ $quiz->description }}</p>
            <p><strong>Mata Pelajaran:</strong> {{ $quiz->mataPelajaran ? $quiz->mataPelajaran->name : 'No Subject' }}</p>
        </div>

        <!-- Questions and Answers -->
        <div>
            <h2 class="text-lg font-semibold">Pertanyaan</h2>
            @foreach ($quiz->questions as $question)
                <div class="mb-4">
                    <p><strong>Pertanyaan:</strong> {{ $question->question_text }}</p>
                    <ul class="list-disc pl-5">
                        @foreach ($question->answers as $answer)
                            <li>
                                {{ $answer->answer_text }}
                                @if ($answer->is_correct)
                                    <span class="text-green-600">(Correct)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Button to go back to the quizzes index -->
        <a href="{{ route('quizzes.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
            Kembali
        </a>
    </div>
</x-app-layout>
