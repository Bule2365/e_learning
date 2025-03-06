<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('guru.tasks.index', compact('tasks'));
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
        return view('guru.tasks.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5', // Membatasi hanya 5 file
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Validasi file (maks 100MB)
            'due_date' => 'required|date',
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

                // Menyimpan file ke dalam direktori 'tasks' dan menyimpan path-nya
                $filePaths[] = $file->store('tasks', 'public');
            }
        }

        // Membuat data tugas baru
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => json_encode($filePaths), // Menyimpan array file dalam format JSON
            'subject_id' => $validated['subject_id'],
            'class_id' => $validated['class_id'],
            'user_id' => Auth::id(),
            'due_date' => $validated['due_date'],
        ]);

        // Mendapatkan siswa yang ada di kelas terkait
        $class = ClassModel::find($validated['class_id']);
        $students = $class->siswa()->pluck('users.id');

        // Menambahkan tugas untuk setiap siswa
        foreach ($students as $student) {
            TaskUser::create([
                'task_id' => $task->id,
                'user_id' => $student,
            ]);
        }

        // Redirect setelah tugas berhasil dibuat
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat');
    }

    public function show(Task $task)
    {
        $siswas = $task->siswa;
        return view('guru.tasks.show', compact('task', 'siswas'));
    }

    public function updateScore(Request $request, Task $task, User $user)
    {
        $request->validate(['score' => 'required|integer|min:0|max:100']);
        TaskUser::where('task_id', $task->id)->where('user_id', $user->id)->update(['score' => $request->score]);
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui');
    }

    public function edit(Task $task)
    {
        // Pastikan hanya guru pemilik tugas yang bisa mengedit
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk mengedit tugas ini.');
        }

        // Ambil daftar mata pelajaran dan kelas
        $subjects = Subject::where('user_id', Auth::id())->get();
        $classes = ClassModel::all();

        return view('guru.tasks.edit', compact('task', 'subjects', 'classes'));
    }

    public function update(Request $request, Task $task)
    {
        // Pastikan hanya guru pemilik tugas yang bisa mengedit
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk mengubah tugas ini.');
        }

        // Validasi input tanpa subject_id dan class_id karena akan otomatis diisi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5', // Maksimal 5 file
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400', // Maksimal 100MB
            'due_date' => 'required|date',
        ]);

        // Ambil subject_id dan class_id secara otomatis berdasarkan tugas
        $subjectId = $task->subject_id; // Mengambil subject_id yang terkait dengan task
        $classId = $task->class_id; // Mengambil class_id yang terkait dengan task

        // Debug: Cek apakah data yang didapat sudah benar
        // dd($subjectId, $classId);

        // Ambil file lama dari database
        $filePaths = json_decode($task->file_path, true) ?? [];

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
                $filePaths[] = $file->store('tasks', 'public');
            }
        }

        // Update tugas, hanya ubah field yang diubah
        $task->update([
            'title' => $validated['title'] !== $task->title ? $validated['title'] : $task->title,
            'description' => $validated['description'] !== $task->description ? $validated['description'] : $task->description,
            'file_path' => $filePaths ? json_encode($filePaths) : $task->file_path,
            'subject_id' => $subjectId, // Menggunakan subject_id yang sudah ada sebelumnya
            'class_id' => $classId, // Menggunakan class_id yang sudah ada sebelumnya
            'due_date' => $validated['due_date'] !== $task->due_date ? $validated['due_date'] : $task->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        // Pastikan hanya guru pemilik tugas yang bisa menghapus
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk menghapus tugas ini.');
        }

        // Hapus file terkait jika ada
        if ($task->file_path) {
            $files = json_decode($task->file_path, true);
            foreach ($files as $file) {
                if (\Storage::disk('public')->exists($file)) {
                    \Storage::disk('public')->delete($file);
                }
            }
        }

        // Hapus tugas dari database
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
