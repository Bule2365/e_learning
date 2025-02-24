<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class AdminExamController extends Controller
{
    /**
     * Tampilkan daftar kelas
     */
    public function index()
    {
        // Ambil semua kelas beserta jumlah ujiannya
        $classes = ClassModel::withCount('ujian')->get();

        // Cek apakah ada kelas yang tersedia
        if ($classes->isEmpty()) {
            return view('admin.exams.index', [
                'classes' => [],
                'message' => 'Tidak ada kelas tersedia.'
            ]);
        }

        return view('admin.exams.index', compact('classes'));
    }

    /**
     * Tampilkan daftar ujian berdasarkan kelas yang dipilih
     */
    public function examsByClass($classId)
    {
        $class = ClassModel::with('ujian')->findOrFail($classId);
        return view('admin.exams.exams_by_class', compact('class'));
    }

    /**
     * Tampilkan daftar siswa berdasarkan ujian yang dipilih
     */
    public function studentsByExam($examId)
    {
        $exam = Exam::with('upayaUjian.user')->findOrFail($examId);
        return view('admin.exams.students_by_exam', compact('exam'));
    }
}
