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

class MateriController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:materi-list|materi-create|materi-edit|materi-delete', only: ['index', 'show']),
            new Middleware('permission:materi-create', only: ['create', 'store']),
            new Middleware('permission:materi-edit', only: ['edit', 'update']),
            new Middleware('permission:materi-delete', only: ['destroy']),
        ];
    }
    public function index()
    {
        $materis = Materi::where('teacher_id', Auth::id())->paginate(10);
        return view('materis.index', compact('materis'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::all(); // Get all Mata Pelajaran for the dropdown
        return view('materis.create', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        // Validate Materi data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|string',
            'url' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'assignment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', // Validate mata_pelajaran_id
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
            $filePath = $request->file('file')->store('materi_files');
            $materi->file = $filePath;
            $materi->save();
        }

        // Handle Assignment upload
        if ($request->hasFile('assignment')) {
            $assignment = new Assignment();
            $assignment->materi_id = $materi->id; // Link the assignment to the created materi
            $assignment->file = $request->file('assignment')->store('assignments');
            $assignment->save();
        }

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
        // Ensure only students can view the materi, you might want to add some authorization logic here
        // This example assumes that the user is authenticated and is a student.
        return view('materis.show', compact('materi'));
    }

}
