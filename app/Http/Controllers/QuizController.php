<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\StudentScoresExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class QuizController extends Controller
{
    public static function middleware(): array
    {
     return [
           new Middleware('permission:quiz-list', only: ['index', 'show']),
           new Middleware('permission:quiz-create', only: ['create', 'store']),
           new Middleware('permission:quiz-edit', only: ['edit', 'update']),
           new Middleware('permission:quiz-delete', only: ['destroy']),
       ];
    }
    public function create()
    {
        $subjects = MataPelajaran::all(); // Fetch subjects for the dropdown
        return view('quizzes.create', compact('subjects'));
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
    //         'questions.*.text' => 'required|string',
    //         'questions.*.answers.*' => 'required|string',
    //         'questions.*.correct_answer' => 'required|integer',
    //         'questions.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// Validasi foto
    //     ]);

    //     $quiz = Quiz::create([
    //         'title' => $validatedData['title'],
    //         'description' => $validatedData['description'],
    //         'mata_pelajaran_id' => $validatedData['mata_pelajaran_id'],
    //     ]);

    //    // Menyimpan setiap pertanyaan dan jawabannya
    //    foreach ($validatedData['questions'] as $index => $questionData) {
    //     // Mengecek apakah ada file foto untuk pertanyaan
    //     $photoPath = null;
    //     if ($request->hasFile('questions.' . $index . '.photo')) {
    //         // Menyimpan foto ke storage/public/questions_photo
    //         $photoPath = $request->file('questions.' . $index . '.photo')->store('public/questions_photo');
    //     }

    //    // Membuat question baru
    //    $question = $quiz->questions()->create([
    //     'question_text' => $questionData['text'],
    //     'photo' => $photoPath ? basename($photoPath) : null, // Menyimpan nama file gambar
    // ]);

    //         foreach ($questionData['answers'] as $answerIndex => $answerText) {
    //             $isCorrect = ($questionData['correct_answer'] == $answerIndex + 1);
    //             $question->answers()->create([
    //                 'answer_text' => $answerText,
    //                 'is_correct' => $isCorrect,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    // }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'questions.*.text' => 'required|string',
            'questions.*.answers.*' => 'required|string',
            'questions.*.correct_answer' => 'required|integer',
            'questions.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:25068', // Validasi foto (opsional)
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            // Insert quiz using insert (bulk insert)
            $quizData = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'mata_pelajaran_id' => $validatedData['mata_pelajaran_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert quiz into the database
            $quizId = DB::table('quizzes')->insertGetId($quizData);

            // Prepare data for questions and answers
            $questionsData = [];
            $answersData = [];
            foreach ($validatedData['questions'] as $index => $questionData) {
                // Handle question photo only if exists
                $photoPath = null;
                if (isset($questionData['photo']) && $request->hasFile("questions.$index.photo")) {
                    $photoPath = $request->file("questions.$index.photo")->store('public/questions_photo');
                }

                // Prepare question data
                $questionsData[] = [
                    'quiz_id' => $quizId,
                    'question_text' => $questionData['text'],
                    'photo' => $photoPath ? basename($photoPath) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Bulk insert questions
            DB::table('questions')->insert($questionsData);

            // Retrieve inserted questions to associate answers
            $insertedQuestions = DB::table('questions')->where('quiz_id', $quizId)->get();

            foreach ($insertedQuestions as $i => $question) {
                $questionData = $validatedData['questions'][$i];
                foreach ($questionData['answers'] as $answerIndex => $answerText) {
                    $answersData[] = [
                        'question_id' => $question->id,
                        'answer_text' => $answerText,
                        'is_correct' => ($questionData['correct_answer'] == $answerIndex + 1),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Bulk insert answers
            DB::table('answers')->insert($answersData);
        });

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }


    public function index()
    {
        $quizzes = Quiz::with('mataPelajaran')->get(); // Eager load mataPelajaran relationship
        Log::info($quizzes);
        return view('quizzes.index', compact('quizzes'));
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function show($id)
    {
        // Eager load questions and answers with the quiz
        $quiz = Quiz::with('mataPelajaran', 'questions.answers')->findOrFail($id);

        return view('quizzes.show', compact('quiz'));
    }

    public function take($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        return view('quizzes.take', compact('quiz'));
    }


    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $score = 0;

        foreach ($quiz->questions as $question) {
            $selectedAnswer = $request->input('question_' . $question->id);
            $correctAnswer = $question->answers()->where('is_correct', true)->first();

            if ($selectedAnswer == $correctAnswer->id) {
                $score++;
            }
        }

        // Save the result
        QuizResult::create([
            'quiz_id' => $id,
            'user_id' => Auth::id(), // Assumes users are logged in
            'score' => $score,
        ]);

        return view('quizzes.result', ['score' => $score, 'total' => $quiz->questions->count()]);
    }

    public function studentScores()
{
    $scores = QuizResult::with('quiz', 'quiz.mataPelajaran', 'user') // Mengambil semua data dari model quizresult
    // dengan relasi quiz, quiz:mataPelajaran, user
        ->get()
        ->groupBy(function ($score) {
            return $score->quiz->mataPelajaran->name; // Mengelompokkan quiz berdasarkan mata pelajaran
        })
        ->map(function ($subjectScores) {
            return $subjectScores->groupBy(function ($score) {
                return $score->quiz->title; // Mengelompokkan berdasarkan judul kuis dalam setiap mata pelajaran
            });
        })
        // menambahkan logika perhitungan dari jumlah soal dengan jumlah jawaban benar
        ->map(function ($subjectScores) {
            return $subjectScores->map(function ($quizScores) {
                return $quizScores->map(function ($score) {
                    $totalQuestions = $score->quiz->questions->count(); // Menghitung jumlah soal dalam kuis
                    $correctAnswers = $score->score; // Mengambil jumlah jawaban benar

                    // Menghitung persentase nilai
                    $percentageScore = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

                    // Menyimpan persentase ke dalam hasil nilai
                    $score->percentage_score = $percentageScore;

                    return $score;
                });
            });
        });

    return view('student-scores.index', ['scores' => $scores]);
}


    public function exportStudentScoresPdf()
    {
        $studentScores = $this->getStudentScores(); // Your method to get scores
        $pdf = Pdf::loadView('pdf.student_scores', ['studentScores' => $studentScores]);

        return $pdf->download('student_scores.pdf');
    }

    private function getStudentScores()
    {
        // Your logic to fetch and structure student scores

    }
}
