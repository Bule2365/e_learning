<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\ClassModel;  // Asumsi ada model Class
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{
    // Menampilkan form untuk menambah relasi kelas dan mata pelajaran
    public function create()
    {
        $subjects = Subject::all();  // Ambil semua mata pelajaran
        $classes = ClassModel::all();  // Ambil semua kelas
        return view('admin.class_subjects.create', compact('subjects', 'classes'));
    }

    // Menyimpan relasi kelas dan mata pelajaran
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        ClassSubject::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id
        ]);

        return redirect()->route('admin.class_subjects.index')->with('success', 'Relasi kelas dan mata pelajaran berhasil ditambahkan.');
    }

    // Menampilkan semua relasi kelas dan mata pelajaran
    public function index()
    {
        $classSubjects = ClassSubject::with(['class', 'subject'])->get();
        return view('admin.class_subjects.index', compact('classSubjects'));
    }
}