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
    
        // Pass kelas yang terpilih ke view
        return view('guru.materials.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5', // Membatasi hanya 5 file
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Validasi file (maks 100MB)
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Menyimpan setiap file
        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Memastikan file yang di-upload tidak lebih dari 100MB
                if ($file->getSize() > 102400000) {
                    return redirect()->back()->with('error', 'Ukuran file tidak boleh lebih dari 100MB.');
                }

                // Menyimpan file ke dalam direktori 'materials' dan menyimpan path-nya
                $filePaths[] = $file->store('materials', 'public');
            }
        }

        // Membuat data materi baru
        $material = Material::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path'   => json_encode(array_map('str_replace', ['\\'], ['/'], $filePaths)), // Menyimpan array file dalam format JSON
            'subject_id' => $validated['subject_id'],
            'class_id' => $validated['class_id'],
            'user_id' => Auth::id(),
        ]);

        // Redirect setelah materi berhasil dibuat
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
    
        // Validasi input tanpa subject_id dan class_id karena akan otomatis diisi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5', // Maksimal 5 file
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Maksimal 100MB
        ]);
    
        // Ambil file lama dari database
        $filePaths = json_decode($material->file_path, true) ?? [];
    
        // Jika ada file baru yang diunggah, hapus file lama dan simpan yang baru
        if ($request->hasFile('files')) {
            // Hapus file lama dari storage
            foreach ($filePaths as $file) {
                \Storage::disk('public')->delete($file);
            }
    
            // Simpan file baru
            $filePaths = [];
            foreach ($request->file('files') as $file) {
                if ($file->getSize() > 102400000) { // 100MB
                    return redirect()->back()->with('error', 'Ukuran file tidak boleh lebih dari 100MB.');
                }
                $filePaths[] = $file->store('materials', 'public');
            }
        }
    
        // Update materi, hanya ubah field yang diubah
        $material->update([
            'title' => $validated['title'] !== $material->title ? $validated['title'] : $material->title,
            'description' => $validated['description'] !== $material->description ? $validated['description'] : $material->description,
            'file_path' => count($filePaths) > 0 ? json_encode($filePaths) : $material->file_path, // Hanya update file jika ada file baru
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
