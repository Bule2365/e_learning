<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;

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
        $exam = Exam::findOrFail($examId);

        // Jika input manual
        if ($request->has('question_text')) {
            $request->validate([
                'question_text' => 'required|string',
                'type' => 'required|in:multiple_choice,essay',
                'options' => 'nullable|array',
                'correct_answer' => 'nullable|string',
            ]);

            // Jika soal pilihan ganda, ubah options ke JSON
            $options = $request->type === 'multiple_choice' ? json_encode($request->options) : null;

            Question::create([
                'exam_id' => $exam->id,
                'question_text' => $request->question_text,
                'options' => $options,
                'correct_answer' => $request->correct_answer,
                'type' => $request->type,
            ]);

            return redirect()->route('guru.exams.show', $examId)->with('success', 'Soal berhasil ditambahkan!');
        }

        // Jika upload file
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:docx,xlsx|max:10240',
            ]);

            $file = $request->file('file');
            $path = $file->store('uploads');
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'docx') {
                $this->processWord($path, $exam);
            } elseif ($extension === 'xlsx') {
                $this->processExcel($path, $exam);
            }

            return redirect()->route('guru.exams.show', $examId)->with('success', 'Soal berhasil diunggah!');
        }

        return back()->with('error', 'Harap isi form atau unggah file.');

        // $exam = Exam::findOrFail($examId);

        // if ($request->hasFile('file')) {
        //     $request->validate([
        //         'file' => 'required|mimes:docx,xlsx|max:10240',
        //     ]);

        //     try {
        //         $file = $request->file('file');
        //         $extension = $file->getClientOriginalExtension();

        //         if ($extension === 'docx') {
        //             $this->processWord($file, $exam);
        //         } elseif ($extension === 'xlsx') {
        //             $this->processExcel($file, $exam);
        //         }

        //         return redirect()->route('guru.exams.show', $examId)
        //             ->with('success', 'Soal berhasil diunggah!');
        //     } catch (\Exception $e) {
        //         return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        //     }
        // }
    }

    // private function processWord($path, $exam)
    // {
    //     $phpWord = \PhpOffice\PhpWord\IOFactory::load(Storage::path($path));
    //     $text = '';

    //     // Membaca semua teks dari file Word
    //     foreach ($phpWord->getSections() as $section) {
    //         foreach ($section->getElements() as $element) {
    //             if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
    //                 foreach ($element->getElements() as $textElement) {
    //                     if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
    //                         $text .= $textElement->getText() . "\n";
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // ✅ REGEX diperbaiki agar jawaban hanya mengambil satu kata/huruf
    //     $pattern = '/Pertanyaan:\s*(.*?)\n(?:A\.\s*(.*?)\nB\.\s*(.*?)\nC\.\s*(.*?)\nD\.\s*(.*?)\n)?Jawaban:\s*([A-D]?)/s';

    //     // Menjalankan regex
    //     preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

    //     foreach ($matches as $match) {
    //         try {
    //             $questionText = trim($match[1]); // Ambil teks pertanyaan
    //             $correctAnswer = isset($match[6]) ? trim($match[6]) : null; // Jawaban harus hanya A, B, C, atau D

    //             // Cek apakah ini soal Multiple Choice atau Essay
    //             $options = [];
    //             if (!empty($match[2]) && !empty($match[3]) && !empty($match[4]) && !empty($match[5])) {
    //                 $options = [
    //                     'A' => trim($match[2]),
    //                     'B' => trim($match[3]),
    //                     'C' => trim($match[4]),
    //                     'D' => trim($match[5]),
    //                 ];
    //             }

    //             // Menentukan tipe soal
    //             $type = !empty($options) ? 'multiple_choice' : 'essay';

    //             // Jika soal essay, tidak perlu jawaban benar
    //             if ($type === 'essay') {
    //                 $correctAnswer = null;
    //             }

    //             // Simpan ke database
    //             Question::create([
    //                 'exam_id' => $exam->id,
    //                 'question_text' => $questionText,
    //                 'options' => !empty($options) ? json_encode($options) : null,
    //                 'correct_answer' => $correctAnswer,
    //                 'type' => $type,
    //             ]);
    //         } catch (\Exception $e) {
    //             \Log::error("Error memproses soal dari Word: " . $e->getMessage());
    //             \Log::info("Isi File Word: " . $text);
    //         }
    //     }
    // }

    private function processWord($uploadedFile, $exam)
    {
        try {
            // 1. Simpan file ke storage
            $path = $uploadedFile->store('exam_files', 'public');
            $fullPath = storage_path('app/public/' . $path);

            // 2. Load file Word
            $phpWord = WordIOFactory::load($fullPath);

            // 3. Ekstrak teks dengan benar
            $text = $this->extractTextFromWord($phpWord);

            // 4. Parse pertanyaan
            $questions = $this->parseQuestionsFromText($text);

            // 5. Simpan ke database dalam transaction
            DB::beginTransaction();
            try {
                foreach ($questions as $question) {
                    Question::create([
                        'exam_id' => $exam->id,
                        'question_text' => $question['question_text'],
                        'options' => $question['options'],
                        'correct_answer' => $question['correct_answer'],
                        'type' => $question['type'],
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            // 6. Hapus file setelah sukses
            Storage::delete('public/' . $path);

            return count($questions);
        } catch (\Exception $e) {
            \Log::error('Error processing Word file: ' . $e->getMessage());
            throw new \Exception('Gagal memproses file Word: ' . $e->getMessage());
        }
    }

    private function extractTextFromWord($phpWord)
    {
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof Text) {
                            $text .= $textElement->getText() . "\n";
                        }
                    }
                } elseif ($element instanceof Text) {
                    $text .= $element->getText() . "\n";
                }
            }
        }
        return $text;
    }

    private function parseQuestionsFromText($text)
    {
        $questions = [];
        $pattern = '/Pertanyaan:\s*(.+?)(\n|$)(?:A\.\s*(.+?)\nB\.\s*(.+?)\nC\.\s*(.+?)\nD\.\s*(.+?)\n)?Jawaban:\s*([A-D]?)(\n|$)/s';

        preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $question = [
                'question_text' => trim($match[1]),
                'options' => [],
                'correct_answer' => null,
                'type' => 'essay'
            ];

            // Deteksi pilihan ganda
            if (!empty($match[3]) && !empty($match[4]) && !empty($match[5]) && !empty($match[6])) {
                $question['type'] = 'multiple_choice';
                $question['options'] = [
                    'A' => trim($match[3]),
                    'B' => trim($match[4]),
                    'C' => trim($match[5]),
                    'D' => trim($match[6])
                ];

                $answer = strtoupper(trim($match[7]));
                $question['correct_answer'] = in_array($answer, ['A', 'B', 'C', 'D']) ? $answer : null;
            }

            $questions[] = $question;
        }

        if (empty($questions)) {
            throw new \Exception('Tidak ditemukan pertanyaan dalam format yang valid');
        }

        return $questions;
    }

    private function processExcel($path, $exam)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(Storage::path($path));
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        \Log::info("Total Baris dalam Excel: " . count($data));

        foreach ($data as $index => $row) {
            if ($index == 0) {
                \Log::info("Skipping header row.");
                continue; // Lewati header
            }

            if (empty($row[0])) {
                \Log::warning("Skipping empty row at index: " . $index);
                continue;
            }

            try {
                $questionText = trim($row[0]); // Pertanyaan
                $options = json_decode($row[1], true); // Decode JSON
                $correctAnswer = trim($row[2]); // Jawaban benar
                $type = trim($row[3]); // Jenis soal

                \Log::info("Processing row $index: $questionText");

                if ($type === 'multiple_choice' && !is_array($options)) {
                    throw new \Exception("Invalid multiple choice options format at row $index.");
                }

                if ($type === 'essay') {
                    $options = null;
                    $correctAnswer = null;
                }

                // Simpan ke database
                Question::create([
                    'exam_id' => $exam->id,
                    'question_text' => $questionText,
                    'options' => $options ? json_encode($options) : null,
                    'correct_answer' => $correctAnswer,
                    'type' => $type,
                ]);
            } catch (\Exception $e) {
                \Log::error("Error processing row $index: " . $e->getMessage());
            }
        }
    }
}
