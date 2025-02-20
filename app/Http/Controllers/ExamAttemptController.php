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
     * Menampilkan daftar ujian
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

        // Buat attempt baru (tidak menghapus data sebelumnya)
        $attempt = ExamAttempt::create([
            'exam_id' => $examId,
            'user_id' => $user->id,
            'started_at' => Carbon::now(),
            'score' => null,
        ]);

        return redirect()->route('siswa.exams.show', ['examId' => $examId, 'attemptId' => $attempt->id]);
    }

    /**
     * Menampilkan soal ujian
     */
    public function show($examId, $attemptId)
    {
        $attempt = ExamAttempt::where('id', $attemptId)
            ->where('exam_id', $examId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $questions = Question::where('exam_id', $examId)->get();

        return view('siswa.exams.show', compact('attempt', 'questions'));
    }

    /**
     * Menyimpan jawaban siswa secara otomatis saat memilih jawaban
     */
    public function saveAnswer(Request $request, $attemptId)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'nullable|string',
        ]);

        $attempt = ExamAttempt::findOrFail($attemptId);
        $question = Question::findOrFail($request->question_id);

        $isCorrect = ($question->type === 'multiple_choice')
            ? strtoupper($request->answer) === strtoupper($question->correct_answer)
            : null;

        ExamAnswer::updateOrCreate(
            [
                'exam_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ],
            [
                'answer' => $request->answer,
                'is_correct' => $isCorrect,
            ]
        );

        return response()->json(['message' => 'Jawaban disimpan.']);
    }

    /**
     * Siswa menyelesaikan ujian & sistem menghitung skor otomatis
     */
    public function submit($attemptId)
    {
        $attempt = ExamAttempt::findOrFail($attemptId);
        $answers = ExamAnswer::where('exam_attempt_id', $attempt->id)->get();
        $questions = Question::where('exam_id', $attempt->exam_id)->get();

        $totalQuestions = $questions->count();
        $totalMCQ = $questions->where('type', 'multiple_choice')->count();
        $totalEssay = $totalQuestions - $totalMCQ;

        // Hitung jawaban benar untuk pilihan ganda
        $correctMCQ = $answers->where('is_correct', true)->count();
        $mcqScore = $totalMCQ > 0 ? ($correctMCQ / $totalMCQ) * 100 : 0;
        $essayScore = 0;

        // Skor akhir ditentukan berdasarkan tipe soal
        $finalScore = ($totalEssay == 0) ? $mcqScore : ($mcqScore * ($totalMCQ / $totalQuestions));

        // Update nilai attempt
        $attempt->update([
            'submitted_at' => Carbon::now(),
            'score' => round($finalScore, 2),
        ]);

        return redirect()->route('siswa.exams.index')->with('success', "Ujian telah dikumpulkan!");
    }
}
