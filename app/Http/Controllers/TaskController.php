<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Menampilkan daftar tugas untuk guru
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('guru.tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Menampilkan form untuk membuat tugas baru
        $classes = ClassModel::all();
        $subjects = Subject::where('user_id', auth()->id())->get();
        return view('guru.tasks.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        // Menyimpan tugas baru
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'user_id' => auth()->id(),
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat');
    }

    public function show(Task $task)
    {
        // Menampilkan detail tugas dan siswa yang mengumpulkan
        $students = $task->students;
        return view('guru.tasks.show', compact('task', 'students'));
    }

    public function updateScore(Request $request, Task $task, User $user)
    {
        // Mengupdate nilai siswa
        $task->students()->updateExistingPivot($user->id, ['score' => $request->score]);
        return redirect()->back()->with('success', 'Nilai berhasil diupdate');
    }
}