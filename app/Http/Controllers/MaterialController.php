<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // Ambil semua materi yang di-upload oleh guru yang sedang login
        $materials = Material::where('user_id', Auth::id())->get();
        return view('guru.materials.index', compact('materials'));
    }

    public function create(Request $request)
    {
        // Ambil ID kelas dari query string URL
        $classId = $request->query('class_id');

        // Ambil semua mata pelajaran yang relevan untuk guru
        $subjects = Subject::where('user_id', Auth::id())->get();

        // Ambil kelas berdasarkan ID jika ada
        $classes = ClassModel::find($classId);

        if (!$classes) {
            // Jika kelas tidak ditemukan, arahkan ke halaman sebelumnya atau tampilkan error
            return redirect()->back()->with('error', 'Kelas dengan ID ' . $classId . ' tidak ditemukan.');
        }

        if ($subjects->isEmpty()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki mata pelajaran yang dapat diajar.');
        }

        // Pass kelas yang terpilih ke view
        return view('guru.materials.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files' => 'nullable|array|max:5', // Maksimal 5 file
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Maksimal 100MB per file
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Array untuk menyimpan path file
        $filePaths = [];

        // Simpan setiap file yang diunggah
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Simpan file ke direktori 'materials'
                $filePaths[] = $file->store('materials', 'public');
            }
        }

        // Pastikan file_paths tetap dalam batas 255 karakter
        $filePathsJson = json_encode($filePaths);
        if (strlen($filePathsJson) > 255) {
            return redirect()->back()->with('error', 'Total panjang path file melebihi batas yang diizinkan.');
        }

        // Simpan ke database
        Material::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePathsJson, // Simpan path dalam format JSON
            'subject_id' => $validated['subject_id'],
            'class_id' => $validated['class_id'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('guru.materials.index')->with('success', 'Materi berhasil dibuat');
    }

    public function show(Material $material)
    {
        return view('guru.materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        // Pastikan hanya guru pemilik materi yang bisa mengedit
        if ($material->user_id !== Auth::id()) {
            return redirect()->route('materials.index')->with('error', 'Anda tidak memiliki akses untuk mengedit materi ini.');
        }

        // Ambil daftar mata pelajaran dan kelas
        $subjects = Subject::where('user_id', Auth::id())->get();
        $classes = ClassModel::all();

        return view('guru.materials.edit', compact('material', 'subjects', 'classes'));
    }

    public function update(Request $request, Material $material)
    {
        // Pastikan hanya guru pemilik materi yang bisa mengedit
        if ($material->user_id !== Auth::id()) {
            return redirect()->route('guru.materials.index')->with('error', 'Anda tidak memiliki akses untuk mengubah materi ini.');
        }
    
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Maks 100MB per file
            'delete_old_files' => 'nullable|array',
        ]);
    
        // Ambil file lama
        $existingFiles = json_decode($material->file_path, true) ?? [];
    
        // Hapus file yang dipilih pengguna
        if ($request->has('delete_old_files')) {
            foreach ($request->delete_old_files as $fileToDelete) {
                if (($key = array_search($fileToDelete, $existingFiles)) !== false) {
                    // Hapus file dari storage
                    if (\Storage::disk('public')->exists($fileToDelete)) {
                        \Storage::disk('public')->delete($fileToDelete);
                    }
                    // Hapus dari array existingFiles
                    unset($existingFiles[$key]);
                }
            }
        }
    
        // Reset array key index
        $existingFiles = array_values($existingFiles);
    
        // Periksa apakah masih ada ruang untuk menambahkan file baru
        $maxFilesAllowed = 5;
        $remainingSlots = $maxFilesAllowed - count($existingFiles);
    
        if ($request->hasFile('files')) {
            $newFiles = $request->file('files');
    
            if (count($newFiles) > $remainingSlots) {
                return redirect()->back()->with('error', 'Anda hanya dapat mengunggah maksimal ' . $remainingSlots . ' file tambahan.');
            }
    
            foreach ($newFiles as $file) {
                $existingFiles[] = $file->store('materials', 'public');
            }
        }
    
        // Simpan data ke database
        $material->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? $material->description,
            'file_path' => json_encode($existingFiles), // Simpan dalam bentuk JSON
        ]);
    
        return redirect()->route('guru.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        // Pastikan hanya guru pemilik materi yang bisa menghapus
        if ($material->user_id !== Auth::id()) {
            return redirect()->route('materials.index')->with('error', 'Anda tidak memiliki akses untuk menghapus materi ini.');
        }

        // Hapus file terkait jika ada
        if ($material->file_path) {
            $files = json_decode($material->file_path, true);
            foreach ($files as $file) {
                if (\Storage::disk('public')->exists($file)) {
                    \Storage::disk('public')->delete($file);
                }
            }
        }

        // Hapus materi dari database
        $material->delete();

        return redirect()->route('guru.materials.index')->with('success', 'Materi berhasil dihapus.');
    }
}
