<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Carbon\Carbon;
use App\Models\Assignment;

class SubmissionController extends Controller
{

    public function index()
    {
        // Fetch paginated list of permissions
        $submissions = Submission::with(['materi', 'mataPelajaran', 'user'])->get();

        $submission = Submission::paginate(10);
        return view('submissions.index', compact('submission'));
    }



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
    if ($request->submission_type === 'document' && $request->hasFile('file_path')) {
        // Gunakan queue untuk memproses file
        $file = $request->file('file_path');

        // Jika ingin mengoptimalkan proses unggah, gunakan disk yang lebih cepat atau kompres file
        $filePath = $file->storeAs('public/submissions', time() . '_' . $file->getClientOriginalName());

        // Simpan file path
        $submission->file_path = $filePath;

        // Optional: Proses file di background menggunakan queue
        // dispatch(new ProcessUploadedFile($submission)); // Misalnya dengan Job/Queue
    }
    // Jika tugas adalah link
    elseif ($request->submission_type === 'link' && $request->filled('submission_link')) {
        // Simpan link yang dikumpulkan
        $submission->submission_link = $request->submission_link;
    }
    // Jika tugas adalah artikel
    elseif ($request->submission_type === 'article' && $request->filled('submission_content')) {
        // Simpan konten artikel
        $submission->submission_content = $request->submission_content;
    }

    $submission->status = 'submitted'; // Set status tugas
    $submission->submitted_at = Carbon::now()->setTimezone('Asia/Jakarta'); // Set waktu pengumpulan
    $submission->save();

    // Redirect kembali ke halaman show materi
    return redirect()->route('materis.show', $submission->assignment->materi_id)
                     ->with('success', 'Tugas berhasil dikumpulkan');
}




}
