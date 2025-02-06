<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\TaskUser;
use App\Models\User;
use Auth;
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
    
        // Pass kelas yang terpilih ke view
        return view('guru.tasks.create', compact('subjects', 'classes'));
    }
    
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'due_date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
        ]);
    
        // Proses penyimpanan file jika ada
        $filePath = $request->hasFile('file') ? $request->file('file')->store('tasks', 'public') : null;
    
        // Membuat data tugas baru
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
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
}
