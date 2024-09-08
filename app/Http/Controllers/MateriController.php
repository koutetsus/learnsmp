<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{

    public function index()
    {
        $materis = Materi::where('teacher_id', Auth::id())->paginate(10);
        return view('materis.index', compact('materis'));
    }

    public function create()
    {
        return view('materis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,article,ppt,video',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi',
            'url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'teacher_id' => Auth::id(),
        ];

        if ($request->type === 'article') {
            $data['content'] = $request->content;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materis');
            $data['url'] = $filePath;
        } elseif ($request->type === 'document' || $request->type === 'ppt') {
            $data['url'] = $request->url;
        }

        Materi::create($data);

        return redirect()->route('materis.index')->with('success', 'Materi created successfully.');
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
