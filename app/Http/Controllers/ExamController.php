<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    // Middleware untuk memastikan hanya guru yang bisa mengakses
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:guru');
    }

    public function index()
    {
        // Ambil guru yang sedang login
        $guru = auth()->user(); // Pastikan user yang login adalah guru

        // Ambil mapel yang diajarkan oleh guru tersebut
        $mapels = $guru->mataPelajaran;

        // Ambil ujian yang berstatus 'draft' atau 'published' dan memiliki mapel yang diajarkan oleh guru
        $exams = Exam::whereIn('subject_id', $mapels->pluck('id'))
            ->where(function ($query) {
                $query->where('status', 'draft')
                    ->orWhere('status', 'published');
            })
            ->get();

        // Kembalikan data ke view
        return view('guru.exams.index', compact('exams'));
    }

    // Halaman untuk membuat ujian baru
    public function create(Request $request)
    {
        // Ambil class_id dari query string
        $classId = $request->query('class_id');

        // Validasi apakah class_id ada di database
        $class = ClassModel::findOrFail($classId);

        // Ambil mata pelajaran yang diajar oleh guru (asumsi ada relasi antara User dan Subject)
        $subjects = Auth::user()->mataPelajaran;

        if ($subjects->isEmpty()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki mata pelajaran yang dapat diajar.');
        }

        return view('guru.exams.create', compact('class', 'subjects'));
    }

    // Simpan data ujian baru
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        // Membuat ujian baru
        Exam::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('guru.exams.index')->with('success', 'Ujian berhasil dibuat.');
    }

    // Menampilkan detail ujian
    public function show($id)
    {
        $exam = Exam::with('kelas', 'mataPelajaran', 'soal')->findOrFail($id);
        return view('guru.exams.show', compact('exam'));
    }

    // Menampilkan form untuk menambah soal
    public function addQuestions($examId)
    {
        $exam = Exam::findOrFail($examId);
        return view('guru.exams.add_questions', compact('exam'));
    }

    // Menyimpan soal ke ujian
    public function storeQuestions(Request $request, $examId)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'options' => 'required|array',
            'correct_answer' => 'required|string|max:255',
            'type' => 'required|in:multiple_choice,essay',
        ]);

        $exam = Exam::findOrFail($examId);

        // Menambahkan soal ke ujian
        $exam->soal()->create([
            'question_text' => $request->question_text,
            'options' => json_encode($request->options),
            'correct_answer' => $request->correct_answer,
            'type' => $request->type,
        ]);

        return redirect()->route('guru.exams.show', $examId);
    }
}
