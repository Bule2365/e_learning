<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStudentController extends Controller
{
    public function index()
    {
        // Mengambil daftar tugas yang tersedia untuk siswa berdasarkan kelas yang diikuti
        $tasks = Task::whereHas('class', function ($query) {
            $query->whereHas('siswa', function ($query) {
                $query->where('user_id', auth()->id());
            });
        })->get();

        return view('siswa.tasks.index', compact('tasks'));
    }

    public function show($taskId)
    {
        // Menampilkan detail tugas
        $task = Task::findOrFail($taskId);

        // Cek apakah siswa sudah mengumpulkan tugas
        $submission = TaskUser::where('task_id', $task->id)
                              ->where('user_id', auth()->id())
                              ->first();

        return view('siswa.tasks.show', compact('task', 'submission'));
    }

    public function submit(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        // Validasi file yang di-upload
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Proses upload file
        $filePath = $request->file('file')->store('task_submissions', 'public');

        // Menyimpan file di kolom 'submission' pada tabel pivot 'task_user'
        TaskUser::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => auth()->id()],
            ['submission' => $filePath]
        );

        return redirect()->route('student.tasks.index')->with('success', 'Tugas berhasil dikumpulkan');
    }
}
