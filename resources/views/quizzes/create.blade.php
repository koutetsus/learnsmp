<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Create Quiz</h1>
    </x-slot>

    <form action="{{ route('quizzes.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <!-- Quiz Details -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" aria-labelledby="title">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" aria-labelledby="description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700">Subject</label>
                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" aria-labelledby="mata_pelajaran_id">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('mata_pelajaran_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Questions Section -->
            <div id="questions" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Initial Question -->
                <div class="question" id="question_1">
                    <label class="block text-sm font-medium text-gray-700">Question 1</label>
                    <input type="text" name="questions[0][text]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Enter the question text">
                    <button type="button" onclick="addAnswer(1)" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add Answer
                    </button>
                    <div id="answers_1" class="mt-2"></div>
                </div>
            </div>

            <button type="button" onclick="addQuestion()" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                Add Another Question
            </button>

            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Save Quiz
            </button>
        </div>
    </form>

    <script>
        let questionCount = 1;

        function addQuestion() {
            questionCount++;
            const questionsContainer = document.getElementById('questions');
            const newQuestionDiv = document.createElement('div');
            newQuestionDiv.classList.add('question');
            newQuestionDiv.id = `question_${questionCount}`;
            newQuestionDiv.innerHTML = `
                <label class="block text-sm font-medium text-gray-700">Question ${questionCount}</label>
                <input type="text" name="questions[${questionCount - 1}][text]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Enter the question text">
                <button type="button" onclick="addAnswer(${questionCount})" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Add Answer
                </button>
                <div id="answers_${questionCount}" class="mt-2"></div>
            `;
            questionsContainer.appendChild(newQuestionDiv);
        }

        function addAnswer(questionId) {
            const answersContainer = document.getElementById(`answers_${questionId}`);
            const answerCount = answersContainer.children.length + 1;
            const newAnswerDiv = document.createElement('div');
            newAnswerDiv.classList.add('flex', 'items-center', 'space-x-2', 'mt-2');
            newAnswerDiv.innerHTML = `
                <input type="radio" name="questions[${questionId - 1}][correct_answer]" value="${answerCount}" id="answer_${questionId}_${answerCount}" aria-labelledby="answer_${questionId}_${answerCount}_text">
                <input type="text" name="questions[${questionId - 1}][answers][]" id="answer_${questionId}_${answerCount}_text" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Answer ${answerCount}">
            `;
            answersContainer.appendChild(newAnswerDiv);
        }
    </script>
</x-app-layout>
