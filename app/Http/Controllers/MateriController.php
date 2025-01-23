<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class MateriController extends Controller implements HasMiddleware
{
    use  HasRoles;
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:materi-list', only: ['index', 'show']),
            new Middleware('permission:materi-create', only: ['create', 'store']),
            new Middleware('permission:materi-edit', only: ['edit', 'update']),
            new Middleware('permission:materi-delete', only: ['destroy']),
        ];
    }


    public function index()
    {

        // Check if the user is 'siswa' and 'admin'
        if (Auth::user()->hasAnyRole(['siswa', 'admin']))  {
        // For siswa admin, show all Materi
        $materis = Materi::paginate(10);

    // Check if the user is 'guru' (teacher)
    } elseif (Auth::user()->hasRole('guru')) {
        // For 'guru', show only the Materi created by the teacher
        $materis = Materi::where('teacher_id', Auth::id())->paginate(10);


    }

        return view('materis.index', compact('materis'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::all(); // Get all Mata Pelajaran for the dropdown
        return view('materis.create', compact('mataPelajaran'));
    }

//     public function store(Request $request)
// {
//     // Validasi input
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'content' => 'nullable|string',
//         'type' => 'required|in:document,article,video,link',
//         'url' => 'nullable|url',
//         'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
//         'assignments_file' => $request->input('assignments_type') === 'document' ? 'required|file|mimes:pdf,doc,docx,ppt,pptx' : 'nullable',
//         'assignments_type' => 'required|in:document,article,link',
//         'assignments_link' => $request->input('assignments_type') === 'link' ? 'required|url' : 'nullable',
//         'assignments_content' => $request->input('assignments_type') === 'article' ? 'required|string' : 'nullable',
//         'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
//         'link' => 'nullable|string',
//     ]);

//     // Gunakan transaksi untuk menjaga konsistensi data
//     DB::transaction(function () use ($request) {
//         // Simpan data Materi
//         $materi = Materi::create([
//             'title' => $request->input('title'),
//             'description' => $request->input('description'),
//             'content' => $request->input('content'),
//             'type' => $request->input('type'),
//             'url' => $request->input('url'),
//             'teacher_id' => Auth::id(),
//             'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
//         ]);

//         // Upload file Materi jika ada
//         if ($request->hasFile('file')) {
//             $filePath = $this->uploadFile($request->file('file'), 'public/materi_files');
//             $materi->update(['file' => $filePath]);
//         }

//         // Simpan link jika tipe adalah 'link'
//         if ($materi->type === 'link' && $request->has('link')) {
//             $materi->update(['link' => $request->input('link')]);
//         }

//         // Simpan data Assignment
//         $assignmentData = [
//             'materi_id' => $materi->id,
//             'assignments_type' => $request->input('assignments_type'),
//             'assignments_file' => $request->hasFile('assignments_file')
//                 ? $this->uploadFile($request->file('assignments_file'), 'public/assignments_files')
//                 : null,
//             'assignments_link' => $request->input('assignments_link'),
//             'assignments_content' => $request->input('assignments_content'),
//         ];

//         Assignment::create($assignmentData);
//     });

//     // Kembalikan response sukses
//     return redirect()->route('materis.index')
//                      ->with('success', 'Materi dan Assignment berhasil disimpan!');
// }

//             /**
//              * Fungsi untuk upload file
//              */
//             private function uploadFile($file, $path)
//             {
//                 $fileName = uniqid() . '_' . $file->getClientOriginalName();
//                 return $file->storeAs($path, $fileName);
//             }

public function store(Request $request)
{
    // Validasi input
    $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'content' => 'nullable|string',
        'type' => 'required|in:document,article,video,link',
        'url' => 'nullable|url',
        'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
    ];

    // Tambahkan validasi dinamis berdasarkan tipe assignment
    if ($request->input('assignments_type') === 'document') {
        $rules['assignments_file'] = 'required|file|mimes:pdf,doc,docx,ppt,pptx';
    } elseif ($request->input('assignments_type') === 'link') {
        $rules['assignments_link'] = 'required|url';
    } elseif ($request->input('assignments_type') === 'article') {
        $rules['assignments_content'] = 'required|string';
    }

    $request->validate($rules);

    // Gunakan transaksi untuk menjaga konsistensi data
    DB::transaction(function () use ($request) {
        // Siapkan data untuk Materi
        $materiData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'url' => $request->input('url'),
            'teacher_id' => Auth::id(),
            'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
            'file' => $request->hasFile('file')
                     ? $this->uploadFile($request->file('file'), 'public/materi_files')
                     : null,
            'link' => $request->input('link'),
        ];

        // Simpan data Materi
        $materi = Materi::create($materiData);

        // Siapkan data untuk Assignment
        $assignmentData = [
            'materi_id' => $materi->id,
            'assignments_type' => $request->input('assignments_type'),
            'assignments_file' => $request->hasFile('assignments_file')
                                  ? $this->uploadFile($request->file('assignments_file'), 'public/assignments_files')
                                  : null,
            'assignments_link' => $request->input('assignments_link'),
            'assignments_content' => $request->input('assignments_content'),
        ];

        // Simpan data Assignment
        Assignment::create($assignmentData);
    });

    // Kembalikan response sukses
    return redirect()->route('materis.index')
                     ->with('success', 'Materi dan Assignment berhasil disimpan!');
}

                /**
                 * Fungsi untuk upload file
                 */
                private function uploadFile($file, $path)
                {
                    // Buat nama file unik
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();

                    // Simpan file di storage yang ditentukan
                    $filePath = $file->storeAs($path, $fileName);

                    // Kembalikan URL publik file
                    return Storage::url($filePath);
                }



    public function edit(Materi $materi)
    {
        return view('materis.edit', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,video,link',
            'url' => 'nullable|url',
        ]);

        $materi->update($request->all());

        return redirect()->route('materis.index')->with('success', 'Materi updated successfully.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()->route('materis.index')->with('success', 'Materi deleted successfully.');
    }

    public function show(Materi $materi)
    {

        $materi->load('assignments');
        // Untuk Materi
        if ($materi->type === 'document' && $materi->file) {
            // Generate the file URL
            $materi->file_url = asset('storage/' . $materi->file);
        }



        if ($materi->type === 'video' && $materi->url) {
            $materi->video_id = $this->extractYoutubeVideoId($materi->url);

        }

        if ($materi->type === 'link' && $materi->link) {
            $materi->link;  // You can store the URL directly, or perform additional processing
        }





        return view('materis.show', compact('materi'));
    }

    private function extractYoutubeVideoId($url)
    {

        if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[2]; // Ambil video_id
        }

        // Jika URL tidak cocok dengan pola di atas, return null
        return null;
    }


    public function displayPdf($id)
{
    $materi = Materi::findOrFail($id);

    // Periksa apakah file ada dan valid
    if (!$materi->file || !Storage::exists($materi->file)) {
        return redirect()->route('materis.index')->with('error', 'File not found.');
    }

    // Dapatkan tipe MIME file
    $mimeType = Storage::mimeType($materi->file);

    // Pastikan file adalah PDF
    if ($mimeType !== 'application/pdf') {
        return redirect()->route('materis.index')->with('error', 'The file is not a PDF.');
    }

    // Tampilkan file PDF langsung di browser
    return response()->file(Storage::path($materi->file), [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline', // Pastikan file ditampilkan, bukan diunduh
    ]);
}



}
