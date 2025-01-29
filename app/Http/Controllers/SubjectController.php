<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // Menampilkan daftar mata pelajaran yang diajarkan oleh guru
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::user()->id)->get();
        return view('guru.subjects.index', compact('subjects'));
    }

    // Menampilkan form untuk membuat mata pelajaran baru
    public function create()
    {
        $classes = ClassModel::all(); // Daftar kelas untuk dipilih
        return view('admin.subjects.create', compact('classes'));
    }

    // Menyimpan mata pelajaran baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id', // Pastikan guru yang dipilih ada
        ]);

        // Menyimpan mata pelajaran
        $subject = Subject::create($validatedData);

        // Mengaitkan mata pelajaran dengan kelas
        $subject->classes()->attach($request->classes);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil dibuat!');
    }

    // Menampilkan form edit mata pelajaran
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $classes = ClassModel::all();
        return view('admin.subjects.edit', compact('subject', 'classes'));
    }

    // Update data mata pelajaran
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($validatedData);

        // Menyimpan pengaitan kembali kelas jika diubah
        $subject->classes()->sync($request->classes);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }
}
