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
        $tasks = Task::whereHas('kelas.siswa', function ($query) {
            // Tambahkan alias untuk id pengguna agar SQL bisa membedakan kolom 'id'
            $query->where('users.id', Auth::id())
                  ->where('users.role', 'siswa');
        })->get();
        
        return view('siswa.tasks.index', compact('tasks'));
    }    

    public function show(Task $task)
    {
        $submission = TaskUser::where('task_id', $task->id)->where('user_id', Auth::id())->first();
        return view('siswa.tasks.show', compact('task', 'submission'));
    }

    public function submit(Request $request, Task $task)
    {
        $request->validate(['file' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048']);
        $filePath = $request->file('file')->store('task_submissions', 'public');

        TaskUser::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => Auth::id()],
            ['submission' => $filePath]
        );

        return redirect()->route('student.tasks.index')->with('success', 'Tugas berhasil dikumpulkan');
    }
}
