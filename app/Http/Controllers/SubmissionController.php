<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Assignment;

class SubmissionController extends Controller
{
    //
    public function store(Request $request)
    {
     // Validasi data input
    $request->validate([
        'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Validasi untuk file
        'submission_type' => 'required|in:document,link,article', // Validasi tipe pengumpulan
        'submission_link' => 'nullable|url', // Validasi untuk link
        'submission_content' => 'nullable|string', // Validasi untuk artikel
    ]);

    // Simpan tugas
    $submission = new Submission();
    $submission->assignment_id = $request->assignment_id;
    $submission->user_id = $request->user_id;
    $submission->submission_type = $request->submission_type;

    // Jika tugas adalah file (document)
    if ($request->submission_type === 'document' && $request->hasFile('assignment_file')) {
        // Simpan file yang diunggah
        $file = $request->file('file_path');
        $filePath = $file->storeAs('public/submissions', time() . '_' . $file->getClientOriginalName());
        $submission->file_path = $filePath;
    }
    // Jika tugas adalah artikel
    elseif ($request->submission_type === 'link' && $request->filled('submission_link')) {
        // Simpan link yang dikumpulkan
        $submission->submission_link = $request->submission_link;
    } elseif ($request->submission_type === 'article' && $request->filled('submission_content')) {
        // Simpan konten artikel
        $submission->submission_content = $request->submission_content;
    }

    $submission->status = 'submitted'; // Set status tugas
    $submission->submitted_at = now(); // Set waktu pengumpulan
    $submission->save();

    // Redirect kembali ke halaman show materi
    return redirect()->route('materis.show', $submission->assignment->materi_id)
                     ->with('success', 'Tugas berhasil dikumpulkan');
    }
}
