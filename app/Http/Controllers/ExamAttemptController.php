<?php

namespace App\Http\Controllers;

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
        // Hanya ambil ujian yang statusnya bukan draft
        $exams = Exam::with('soal')
            ->where('status', '!=', 'draft') // Pastikan ujian bukan draft
            ->orderBy('id', 'desc')
            ->get();

        return view('siswa.exams.index', compact('exams'));
    }

    /**
     * Siswa memulai ujian
     */
    public function start($examId)
    {
        $user = Auth::user();

        // Cek apakah siswa sudah pernah mengerjakan ujian ini
        $existingAttempt = ExamAttempt::where('exam_id', $examId)
            ->where('user_id', $user->id)
            ->whereNull('submitted_at') // Belum selesai
            ->first();

        if ($existingAttempt) {
            return redirect()->route('siswa.exams.show', ['examId' => $examId, 'attemptId' => $existingAttempt->id]);
        }

        // Buat attempt baru jika belum ada
        $attempt = ExamAttempt::create([
            'exam_id' => $examId,
            'user_id' => $user->id,
            'started_at' => Carbon::now(),
            'score' => null,
        ]);

        return redirect()->route('siswa.exams.show', ['examId' => $examId, 'attemptId' => $attempt->id]);
    }

    /**
     * Menampilkan soal ujian yang sedang dikerjakan siswa
     */
    public function show($examId, $attemptId)
    {
        // Ambil attempt berdasarkan id
        $attempt = ExamAttempt::where('id', $attemptId)
            ->where('exam_id', $examId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Mengambil soal yang terkait dengan ujian
        $soal = $attempt->exam->soal; // Memanfaatkan relasi exam->soal

        return view('siswa.exams.show', compact('attempt', 'soal'));
    }

    /**
     * Menyimpan jawaban siswa secara otomatis saat memilih jawaban
     */
    public function saveAnswer(Request $request, $attemptId)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'nullable|string|max:1000', // Batasan karakter jawaban
        ]);

        // Cek apakah attempt ada
        $attempt = ExamAttempt::findOrFail($attemptId);
        $question = Question::findOrFail($request->question_id);

        // Pastikan jawaban MC valid (A, B, C, D) atau essay boleh kosong
        if ($question->type === 'multiple_choice' && !in_array(strtoupper($request->answer), ['A', 'B', 'C', 'D', ''])) {
            return response()->json(['success' => false, 'message' => 'Jawaban tidak valid untuk soal pilihan ganda.']);
        }

        // Cari apakah sudah ada jawaban sebelumnya
        $existingAnswer = ExamAnswer::where('exam_attempt_id', $attempt->id)
            ->where('question_id', $question->id)
            ->first();

        try {
            if (!$existingAnswer) {
                // Jika belum ada jawaban, buat baru
                ExamAnswer::create([
                    'exam_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer' => $request->answer,
                    'is_correct' => $question->type === 'multiple_choice'
                        ? (strtoupper($request->answer) === strtoupper($question->correct_answer))
                        : null, // Essay tetap null
                ]);
            } else {
                // Jika sudah ada jawaban, update
                $existingAnswer->update([
                    'answer' => $request->answer,
                    'is_correct' => $question->type === 'multiple_choice'
                        ? (strtoupper($request->answer) === strtoupper($question->correct_answer))
                        : null, // Essay tetap null
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Jawaban berhasil disimpan.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban.',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Siswa menyelesaikan ujian & sistem menghitung skor otomatis
     */
    public function submit($attemptId)
    {
        $attempt = ExamAttempt::with(['exam', 'upayaUjian'])->findOrFail($attemptId);

        // Ambil semua jawaban terkait dengan attempt ini
        $answers = $attempt->upayaUjian ?? collect(); // Pastikan jawaban tidak null
        $questions = $attempt->exam->soal;

        if ($questions->isEmpty()) {
            return redirect()->route('siswa.exams.index')->with('error', 'Soal tidak ditemukan untuk ujian ini.');
        }

        // Hitung jumlah soal berdasarkan tipe
        $totalMCQ = $questions->where('type', 'multiple_choice')->count();
        $totalEssay = $questions->where('type', 'essay')->count();
        $totalQuestions = $totalMCQ + $totalEssay;

        // **Hitung jawaban Multiple Choice**
        $mcqCorrect = $answers->where('is_correct', true)->count();
        $mcqWrong = $answers->where('is_correct', false)->count();
        $mcqUnanswered = $totalMCQ - ($mcqCorrect + $mcqWrong); // Jika siswa tidak menjawab

        // **Hitung jawaban Essay**
        $essayAnswered = $answers->whereNotNull('answer') // Menyaring jawaban esai yang tidak null
            ->whereIn('question_id', $questions->where('type', 'essay')->pluck('id'))
            ->count();

        // Jika jawaban esai null, beri nilai 2, jika tidak null beri nilai 4
        $essayUnanswered = $totalEssay - $essayAnswered; // Jika siswa tidak menjawab

        // **Hitung nilai untuk MCQ**
        $mcqScore = ($mcqCorrect * 4) + ($mcqWrong * 2) + ($mcqUnanswered * 0);

        // **Hitung nilai untuk Essay**
        // Jika soal esai dijawab, beri nilai 4, jika tidak beri nilai 2
        $essayScore = ($essayAnswered * 4) + ($essayUnanswered * 2);

        // **Skor total (jumlah skor MCQ dan Essay)**
        $totalScore = $mcqScore + $essayScore;

        // **Skor maksimal**
        $maxScore = ($totalMCQ * 4) + ($totalEssay * 4); // Nilai maksimal jika semua soal benar

        // **Skalakan skor akhir agar selalu antara 0 dan 100**
        $finalScore = ($maxScore > 0) ? round(($totalScore / $maxScore) * 100, 2) : 0;

        // Simpan nilai ujian
        $attempt->update([
            'submitted_at' => Carbon::now(),
            'score' => $finalScore,
        ]);

        return redirect()->route('siswa.exams.index')->with('success', "Ujian selesai! Nilai Anda: $finalScore");
    }

    /**
     * Siswa melakukan remedial jika nilai kurang dari 75
     */
    public function remedial($examId)
    {
        $user = Auth::user();

        // Hitung jumlah attempt yang sudah dilakukan siswa
        $totalAttempts = ExamAttempt::where('exam_id', $examId)
            ->where('user_id', $user->id)
            ->count();

        if ($totalAttempts >= 3) {
            return redirect()->route('siswa.exams.index')->with('error', 'Anda telah mencapai batas maksimal remedial.');
        }

        // Buat attempt baru untuk remedial
        $attempt = ExamAttempt::create([
            'exam_id' => $examId,
            'user_id' => $user->id,
            'started_at' => now(),
            'score' => null, // Reset nilai
        ]);

        return redirect()->route('siswa.exams.show', ['examId' => $examId, 'attemptId' => $attempt->id])
            ->with('info', 'Silakan mengerjakan ulang ujian.');
    }

    /**
     * Menampilkan halaman persiapan sebelum ujian dimulai.
     */
    public function preparation($examId)
    {
        $exam = Exam::findOrFail($examId);

        return view('siswa.exams.preparation', compact('exam'));
    }
}
