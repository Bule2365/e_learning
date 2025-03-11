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
        $classId = $request->query('class_id');
        $subjects = Subject::where('user_id', Auth::id())->get();
        $classes = ClassModel::find($classId);

        if (!$classes) {
            return redirect()->back()->with('error', 'Kelas dengan ID ' . $classId . ' tidak ditemukan.');
        }

        if ($subjects->isEmpty()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki mata pelajaran yang dapat diajar.');
        }

        return view('guru.tasks.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400',
            'due_date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePaths[] = $file->store('tasks', 'public');
            }
        }

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => json_encode($filePaths),
            'subject_id' => $validated['subject_id'],
            'class_id' => $validated['class_id'],
            'user_id' => Auth::id(),
            'due_date' => $validated['due_date'],
        ]);

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
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk mengubah tugas ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf,jpeg,png,jpg,mp4,avi,mov|max:102400',
            'due_date' => 'required|date',
            'delete_old_files' => 'nullable|array',
        ]);

        $existingFiles = json_decode($task->file_path, true) ?? [];

        // Hapus file lama jika ada permintaan penghapusan
        if ($request->has('delete_old_files')) {
            foreach ($request->delete_old_files as $fileToDelete) {
                if (($key = array_search($fileToDelete, $existingFiles)) !== false) {
                    if (Storage::disk('public')->exists($fileToDelete)) {
                        Storage::disk('public')->delete($fileToDelete);
                    }
                    unset($existingFiles[$key]);
                }
            }
        }

        $existingFiles = array_values($existingFiles); // Reset index array

        // Tambahkan file baru jika ada slot tersedia
        $maxFilesAllowed = 5;
        $remainingSlots = $maxFilesAllowed - count($existingFiles);

        if ($request->hasFile('files')) {
            $newFiles = $request->file('files');

            if (count($newFiles) > $remainingSlots) {
                return redirect()->back()->with('error', 'Anda hanya dapat mengunggah maksimal ' . $remainingSlots . ' file tambahan.');
            }

            foreach ($newFiles as $file) {
                $existingFiles[] = $file->store('tasks', 'public');
            }
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => json_encode($existingFiles),
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk menghapus tugas ini.');
        }

        if ($task->file_path) {
            $files = json_decode($task->file_path, true);
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function deleteFile(Task $task, $file)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Anda tidak memiliki akses untuk menghapus file ini.');
        }

        $currentFiles = json_decode($task->file_path, true) ?? [];

        if (!in_array($file, $currentFiles)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }

        $updatedFiles = array_values(array_filter($currentFiles, function ($existingFile) use ($file) {
            return $existingFile !== $file;
        }));

        $task->update(['file_path' => json_encode($updatedFiles)]);

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }
}
