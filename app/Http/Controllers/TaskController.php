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
        // Menampilkan daftar tugas untuk guru yang sedang login
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('guru.tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Ambil mata pelajaran yang diajarkan oleh guru yang sedang login
        $subjects = Subject::where('user_id', auth()->id())->get();
    
        // Ambil kelas yang terkait dengan guru (kelas yang diampu oleh guru)
        $classes = ClassModel::whereHas('guru', function($query) {
            $query->where('user_id', auth()->id());
        })->get();
    
        return view('guru.tasks.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048', // Validasi file
            'due_date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
        ]);
    
        // Menyimpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tasks', 'public');
        }
    
        // Menyimpan tugas baru dengan kolom yang sudah otomatis terisi
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'user_id' => auth()->id(),
            'due_date' => $request->due_date,
        ]);
    
        // Menambahkan siswa ke tugas (dengan asumsi semua siswa dalam kelas ini akan ditugaskan)
        $class = ClassModel::find($request->class_id);
        $class->siswa()->attach($task->id); // Menambahkan semua siswa dalam kelas
    
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
        // Mengupdate nilai siswa di tugas ini
        $task->students()->updateExistingPivot($user->id, ['score' => $request->score]);
        return redirect()->back()->with('success', 'Nilai berhasil diupdate');
    }
}
