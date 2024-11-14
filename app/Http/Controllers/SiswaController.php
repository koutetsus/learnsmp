<?php

namespace App\Http\Controllers;


use App\Models\Materi;
use App\Models\Quiz;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // public static function middleware(): array
    // {
    //  return [
    //        new Middleware('permission:materi-list', only: ['index', 'show']),
    //        new Middleware('permission:quiz-list', only: ['index', 'show']),

    //    ];
    // }

    //
    public function index()
    {
        // Mengambil semua materi dan quiz dari database
        $materis = Materi::all();
        $quizzes = Quiz::all();

        // Mengembalikan view dengan data materi dan quiz
        return view('siswa.materi.index', compact('materis', 'quizzes'));
    }
}
