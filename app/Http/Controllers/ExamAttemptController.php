<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:siswa');
    }

    /**
     * Menampilkan daftar ujian untuk siswa
     */
    public function index()
    {
        $exams = Exam::all();
        return view('siswa.exams.index', compact('exams'));
    }

    /**
     * Siswa memulai ujian
     */
    public function start($examId)
    {
        $user = Auth::user();

        // Cek jika siswa sudah punya ujian yang belum dikumpulkan
        $attempt = ExamAttempt::where('exam_id', $examId)
            ->where('user_id', $user->id)
            ->whereNull('submitted_at')
            ->first();

        if (!$attempt) {
            $attempt = ExamAttempt::create([
                'exam_id' => $examId,
                'user_id' => $user->id,
                'started_at' => Carbon::now(),
                'score' => null, // Skor nanti dihitung oleh sistem/guru
            ]);
        }

        return redirect()->route('siswa.exams.show', ['examId' => $examId, 'attemptId' => $attempt->id]);
    }

    /**
     * Menampilkan soal ujian
     */
    public function show($examId, $attemptId)
    {
        // Ambil data attempt beserta exam
        $attempt = ExamAttempt::with('exam')->where('id', $attemptId)
            ->where('exam_id', $examId)
            ->where('user_id', auth()->id()) // Pastikan hanya siswa terkait yang bisa melihat
            ->first();
    
        // Jika tidak ditemukan, redirect dengan error
        if (!$attempt || !$attempt->exam) {
            return redirect()->route('siswa.exams.index')->with('error', 'Ujian tidak ditemukan atau tidak valid.');
        }
    
        // Ambil semua pertanyaan dari ujian
        $questions = Question::where('exam_id', $examId)->get();
    
        return view('siswa.exams.show', compact('attempt', 'questions'));
    }

    /**
     * Menyimpan jawaban siswa
     */
    public function answer(Request $request, $attemptId)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $attempt = ExamAttempt::findOrFail($attemptId);

        foreach ($request->answers as $questionId => $answer) {
            $question = Question::findOrFail($questionId);

            // Cek apakah jawaban benar (hanya untuk Multiple Choice)
            $isCorrect = null;
            if ($question->type === 'multiple_choice' && !empty($question->correct_answer)) {
                $isCorrect = strtoupper($answer) === strtoupper($question->correct_answer);
            }

            // Simpan jawaban siswa
            ExamAnswer::updateOrCreate(
                [
                    'exam_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer' => $answer,
                    'is_correct' => $isCorrect,
                ]
            );
        }

        return back()->with('success', 'Jawaban berhasil disimpan!');
    }

    /**
     * Siswa menyelesaikan ujian & sistem menghitung nilai otomatis
     */
    public function submit($attemptId)
    {
        $attempt = ExamAttempt::findOrFail($attemptId);
        $questions = Question::where('exam_id', $attempt->exam_id)->get();
        $answers = ExamAnswer::where('exam_attempt_id', $attempt->id)->get();

        $totalQuestions = $questions->count();
        $totalMCQ = $questions->where('type', 'multiple_choice')->count();
        $totalEssay = $totalQuestions - $totalMCQ;

        // Hitung jawaban benar untuk Multiple Choice
        $correctMCQ = $answers->where('is_correct', true)->count();

        // Kalkulasi nilai otomatis
        $mcqScore = $totalMCQ > 0 ? ($correctMCQ / $totalMCQ) * 100 : 0; 
        $essayScore = 0; // Default, guru yang akan menilai

        // Skor akhir sebelum penilaian essay oleh guru
        $finalScore = ($mcqScore * ($totalMCQ / $totalQuestions)) + ($essayScore * ($totalEssay / $totalQuestions));

        // Update nilai & waktu submit
        $attempt->update([
            'submitted_at' => Carbon::now(),
            'score' => round($finalScore, 2), // Dibulatkan 2 desimal
        ]);

        return redirect()->route('siswa.exams.result', $attempt->id)->with('success', "Ujian telah dikumpulkan!");
    }

    /**
     * Menampilkan hasil ujian siswa
     */
    public function result($attemptId)
    {
        $attempt = ExamAttempt::where('id', $attemptId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $answers = ExamAnswer::where('exam_attempt_id', $attempt->id)->get();
        return view('siswa.exams.result', compact('attempt', 'answers'));
    }
}