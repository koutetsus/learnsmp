<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Take Quiz: {{ $quiz->title }}</h1>
    </x-slot>

    <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST">
        @csrf
        <div class="py-6">
            <!-- Display Questions -->
            @foreach ($quiz->questions as $question)
                <div class="mb-6">
                    <p class="text-lg font-semibold">{{ $question->question_text }}</p>
                    <div class="mt-2">
                        @foreach ($question->answers as $answer)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $answer->id }}" id="answer_{{ $question->id }}_{{ $answer->id }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="answer_{{ $question->id }}_{{ $answer->id }}" class="ml-2 text-sm text-gray-600">{{ $answer->answer_text }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Submit Quiz
            </button>
        </div>
    </form>
</x-app-layout>
