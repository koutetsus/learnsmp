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

    // public function store(Request $request)
    // {
    //     // Validate Materi data
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'content' => 'nullable|string',
    //         'type' => 'required|string',
    //         'url' => 'nullable|url',
    //         'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
    //         'assignment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
    //         'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', // Validate mata_pelajaran_id
    //         'link' => 'nullable|string',
    //     ]);

    //     // Store Materi data
    //     $materi = Materi::create([
    //         'title' => $request->input('title'),
    //         'description' => $request->input('description'),
    //         'content' => $request->input('content'),
    //         'type' => $request->input('type'),
    //         'url' => $request->input('url'),
    //         'teacher_id' => Auth::id(),
    //         'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
    //     ]);

    //     // Handle file upload for Materi
    //     if ($request->hasFile('file')) {
    //         $filePath = $request->file('file')->store('materi_files');
    //         $materi->file = $filePath;
    //         $materi->save();
    //     }

    //     // Handle 'link google drive' field if the type is 'link google drive'
    //     if ($materi->type === 'link' && $request->has('link')) {
    //         $materi->link = $request->input('link'); // Save Google Drive link if type is 'linkdrive'
    //         $materi->save();
    //     }

    //     // Handle Assignment upload
    //     if ($request->hasFile('assignment')) {
    //         $assignment = new Assignment();
    //         $assignment->materi_id = $materi->id; // Link the assignment to the created materi
    //         $assignment->file = $request->file('assignment')->store('assignments');
    //         $assignment->save();
    //     }

    //     return redirect()->route('materis.index')->with('success', 'Materi and Assignment saved successfully!');
    // }


    public function store(Request $request)
    {
        // Validate Materi data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:document,article,video,link',
            'url' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'assignments_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'assignments_type' => 'required|in:document,article,link',
            'assignments_link' => 'nullable|url', // Validasi untuk link assignment
            'assignments_content' => 'nullable|string', // Validasi untuk artikel content
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', // Validate mata_pelajaran_id
            'link' => 'nullable|string', // Validate linkdrive field when type is 'linkdrive'
        ]);

        // Store Materi dan tugas data
        $materi = Materi::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'url' => $request->input('url'),
            'teacher_id' => Auth::id(),
            'mata_pelajaran_id' => $request->input('mata_pelajaran_id'),
        ]);

        // Handle file upload for Materi
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/materi_files');
            $materi->file = $filePath;
            $materi->save();
        }

        // Handle 'linkdrive' field if the type is 'linkdrive'
        if ($materi->type === 'link' && $request->has('link')) {
            $materi->link = $request->input('link'); // Save Google Drive link if type is 'linkdrive'
            $materi->save();
        }


        //   // Menangani Assignment
        //   $assignment = new Assignment();
        //   $assignment->materi_id = $materi->id;
        //   $assignmentType = $request->input('assignments_type');

        //   // If the assignment is a document (file)
        //   if ($assignmentType === 'document' && $request->hasFile('assignments_file')) {
        //       $file = $request->file('assignments_file');
        //       $filePath = $file->storeAs('public/assignments_files', $file->getClientOriginalName());
        //       $assignment->file = $filePath;
        //       $assignment->type = $file->getClientOriginalExtension(); // Store the file extension as the type
        //   }

        //   // If the assignment is a link
        //   elseif ($assignmentType === 'link' && $request->has('assignments_link')) {
        //       $assignment->assignments_link = $request->input('assignments_link');
        //   }

        //   // If the assignment is an article
        //   elseif ($assignmentType === 'article' && $request->has('assignments_content')) {
        //       $assignment->assignments_content = $request->input('assignments_content');
        //   }

        //   // Save the assignment
        //   $assignment->save();

        // Menangani Assignment
                $assignment = new Assignment();
                $assignment->materi_id = $materi->id;
                $assignmentType = $request->input('assignments_type');

                // If the assignment is a document (file)
                if ($assignmentType === 'document') {
                    if ($request->hasFile('assignments_file')) {
                        $file = $request->file('assignments_file');
                        // Store file with a unique name to avoid overwriting existing files
                        $filePath = $file->storeAs('public/assignments_files', $file->getClientOriginalName());
                        $assignment->assignments_file = $filePath; // Store file path in the assignments_file column
                    } else {
                        // Optionally, you can add validation here to ensure that a file is required for the 'document' type
                        // Or, handle it by setting an error message if no file is uploaded for document type
                    }
                }

                // If the assignment is a link
                elseif ($assignmentType === 'link' && $request->has('assignments_link')) {
                    $assignment->assignments_link = $request->input('assignments_link');
                }

                // If the assignment is an article
                elseif ($assignmentType === 'article' && $request->has('assignments_content')) {
                    $assignment->assignments_content = $request->input('assignments_content');
                }

                // Set the assignment type
                $assignment->assignments_type = $assignmentType; // Ensure the assignment type is saved in the database

                // Save the assignment
                $assignment->save();



        // Return success message
        return redirect()->route('materis.index')->with('success', 'Materi and Assignment saved successfully!');
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
