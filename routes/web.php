<?php

use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('materis', MateriController::class);
    Route::get('materis/{materi}', [MateriController::class, 'show'])->name('materis.show');
    Route::get('/materis/{id}/pdf', [MateriController::class, 'displayPdf'])->name('materis.displayPdf');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::resource('submissions', SubmissionController::class);


    Route::resource('quizzes', QuizController::class);
    Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store'])->name('mataPelajaran.store');

    Route::get('/quizzes/{id}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{id}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/student-scores', [QuizController::class, 'studentScores'])->name('student-scores');

    Route::get('/student-scores/export', [QuizController::class, 'exportStudentScoresPdf'])->name('student-scores.export');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.materi.index');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.quiz.index');

});

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
