<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class AdminExamController extends Controller
{
    public function index()
    {
        // Ambil semua data siswa yang telah mengikuti ujian
        $examAttempts = ExamAttempt::with('user', 'exam')->get();

        return view('admin.exams.index', compact('examAttempts'));
    }

    public function show($id)
    {
        // Ambil data detail ujian berdasarkan ID
        $examAttempt = ExamAttempt::with('user', 'exam', 'upayaUjian')->findOrFail($id);

        return view('admin.exams.show', compact('examAttempt'));
    }
}
