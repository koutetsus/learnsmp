<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        MataPelajaran::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->back()->with('success', 'Mata Pelajaran created successfully!');
    }
}
