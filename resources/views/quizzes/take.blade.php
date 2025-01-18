<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Take Quiz: {{ $quiz->title }}</h1>
    </x-slot>

    <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST" id="quizForm">
        @csrf
        <div class="py-6 flex">
            <!-- Quiz Content -->
            <div class="w-full">
                <!-- Timer at the Top Right -->
                <div class="flex justify-between items-center mb-6">
                    <div></div>
                    <div class="text-sm">
                        Time Remaining: <span id="timer" class="font-bold text-red-600">00:00</span>
                    </div>
                </div>

                <div id="questions-container">
                    @foreach ($quiz->questions as $index => $question)
                        <div class="question-container" id="question_{{ $index }}" data-question-id="{{ $question->id }}" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                            <div class="mb-4">
                                <p class="text-lg font-semibold">{{ $question->question_text }}</p>

                                <!-- Display Photo if exists -->
                                @if ($question->photo)
                                <div class="mt-2 mb-4 flex justify-center">
                                    <img src="{{ asset('storage/questions_photo/' . $question->photo) }}" alt="Question Image" class="max-w-xs mx-auto">
                                </div>
                                @else
                                <!-- Space for questions without images -->
                                <div class="mt-4 mb-4 h-24 bg-gray-200 rounded-lg"></div>
                                @endif

                                <div class="mt-2">
                                    @foreach ($question->answers as $answer)
                                    <div class="flex items-center space-x-2 mb-2">
                                        <input type="radio" name="question_{{ $question->id }}" value="{{ $answer->id }}" id="answer_{{ $question->id }}_{{ $answer->id }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="answer_{{ $question->id }}_{{ $answer->id }}" class="ml-2 text-sm text-gray-600">{{ $answer->answer_text }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-6">
                    <div>
                        <button type="button" id="prev-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700" onclick="prevQuestion()">Previous</button>
                        <button type="button" id="next-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700" onclick="nextQuestion()">Next</button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-center">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Submit Quiz
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let currentQuestionIndex = 0;
        const totalQuestions = {{ count($quiz->questions) }};
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let timeRemaining = 1800; // 30 minutes in seconds (adjust as needed)

        // Timer Countdown Function
        function startTimer() {
            setInterval(function() {
                if (timeRemaining <= 0) return;

                timeRemaining--;
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                document.getElementById('timer').textContent = `${formatTime(minutes)}:${formatTime(seconds)}`;
            }, 1000);
        }

        function formatTime(time) {
            return time < 10 ? `0${time}` : time;
        }

        // Function to navigate to a specific question
        function goToQuestion(index) {
            if (index >= 0 && index < totalQuestions) {
                // Hide current question
                document.querySelector(`#question_${currentQuestionIndex}`).style.display = 'none';
                // Show new question
                currentQuestionIndex = index;
                document.querySelector(`#question_${currentQuestionIndex}`).style.display = 'block';
                updateButtonVisibility();
            }
        }

        // Function to navigate to the next question
        function nextQuestion() {
            if (currentQuestionIndex < totalQuestions - 1) {
                goToQuestion(currentQuestionIndex + 1);
            }
        }

        // Function to navigate to the previous question
        function prevQuestion() {
            if (currentQuestionIndex > 0) {
                goToQuestion(currentQuestionIndex - 1);
            }
        }

        // Update button visibility based on the current question
        function updateButtonVisibility() {
            prevBtn.style.display = currentQuestionIndex === 0 ? 'none' : 'inline-flex';
            nextBtn.style.display = currentQuestionIndex === totalQuestions - 1 ? 'none' : 'inline-flex';
        }

        // Initialize the first question and start the timer
        goToQuestion(0);
        startTimer();
    </script>
</x-app-layout>
