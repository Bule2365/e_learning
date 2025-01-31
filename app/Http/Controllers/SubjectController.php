<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // Menampilkan daftar mata pelajaran yang diajarkan oleh guru (admin dapat melihat semua)
    public function index()
    {
        $subjects = Subject::all();  // Admin melihat semua mata pelajaran
        return view('admin.subjects.index', compact('subjects'));
    }

    // Menampilkan form untuk membuat mata pelajaran baru
    public function create()
    {
        // Ambil data pengguna dengan role 'guru'
        $users = User::where('role', 'guru')->get();
        return view('admin.subjects.create', compact('users'));
    }

    // Menyimpan mata pelajaran baru
    public function store(Request $request)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id', // Pastikan guru yang dipilih ada
        ]);

        // Simpan mata pelajaran ke database
        Subject::create($validatedData);

        // Redirect ke daftar mata pelajaran dengan pesan sukses
        return redirect()->route('subjects.index')->with('success', 'Mata Pelajaran berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit mata pelajaran
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);  // Ambil mata pelajaran berdasarkan ID
        $users = User::where('role', 'guru')->get();  // Ambil data pengguna dengan peran 'guru'
        return view('admin.subjects.edit', compact('subject', 'users'));
    }

    // Mengupdate mata pelajaran
    public function update(Request $request, $id)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',  // Pastikan guru yang dipilih ada
        ]);

        $subject = Subject::findOrFail($id);  // Ambil mata pelajaran berdasarkan ID
        $subject->update($validatedData);  // Update data mata pelajaran

        // Redirect ke daftar mata pelajaran dengan pesan sukses
        return redirect()->route('subjects.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    // Menghapus mata pelajaran
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);  // Ambil mata pelajaran berdasarkan ID
        $subject->delete();  // Hapus mata pelajaran

        // Redirect ke daftar mata pelajaran dengan pesan sukses
        return redirect()->route('subjects.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}
