<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Traits\HasRoles;

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
            'assignment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', // Validate mata_pelajaran_id
            'link' => 'nullable|string', // Validate linkdrive field when type is 'linkdrive'
        ]);

        // Store Materi data
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

        // Handle Assignment upload
        if ($request->hasFile('assignment')) {
            $assignment = new Assignment();
            $assignment->materi_id = $materi->id; // Link the assignment to the created materi
            $assignment->file = $request->file('assignment')->store('assignments');
            $assignment->save();
        }

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

        if ($materi->type === 'document' && $materi->file) {
            // Generate the file URL
            $materi->file_url = asset('storage/' . $materi->file);
        }

        if ($materi->type === 'video' && $materi->url) {
            $materi->video_id = $this->extractYoutubeVideoId($materi->url);

        }

        if ($materi->type === 'link' && $materi->url) {
            $materi->drive_link = $materi->url;  // You can store the URL directly, or perform additional processing
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


}
