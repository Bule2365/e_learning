<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $guru = auth()->user();

        // Ambil mata pelajaran yang diajarkan oleh guru (pastikan relasi benar)
        $mapels = $guru->mataPelajaran;

        // Jika guru tidak mengajar mata pelajaran apa pun, kembalikan koleksi kosong
        if ($mapels->isEmpty()) {
            $exams = collect(); // Koleksi kosong agar tidak error di Blade
        } else {
            // Ambil ujian yang dibuat oleh guru yang login dan berelasi dengan mata pelajaran yang diajarkan
            $exams = Exam::where('user_id', $guru->id) // Pastikan hanya ujian dari guru ini
                ->whereIn('subject_id', $mapels->pluck('id'))
                ->whereIn('status', ['draft', 'published'])
                ->orderBy('created_at', 'desc') // Ujian terbaru lebih dulu
                ->get();
        }

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

        // Tambahkan user_id untuk menyimpan siapa yang membuat ujian ini
        Exam::create([
            'user_id' => auth()->id(),
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
        $exams = auth()->user()->exams;
        // dd($exams);

        $exam = Exam::with('kelas', 'mataPelajaran', 'soal')->findOrFail($id);
        return view('guru.exams.show', compact('exam'));
    }

    public function edit($id)
    {
        $exam = Exam::with('soal')
            ->where('id', $id)
            ->whereHas('user', function ($query) {
                $query->where('id', auth()->id())->where('role', 'guru');
            })
            ->firstOrFail();

        $classes = ClassModel::all();
        $subjects = Subject::all();

        return view('guru.exams.edit', compact('exam', 'classes', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        // Ambil ujian hanya jika dibuat oleh user yang sedang login
        $exam = Exam::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $exam->update($validated);

        return redirect()->route('guru.exams.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $exam = Exam::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Hapus semua soal yang terkait
        $exam->soal()->delete();

        // Hapus ujian
        $exam->delete();

        return redirect()->route('guru.exams.index')->with('success', 'Ujian berhasil dihapus.');
    }

    // Menampilkan form untuk menambah soal
    public function addQuestions($examId)
    {
        $exam = Exam::findOrFail($examId);
        return view('guru.exams.add_questions', compact('exam'));
    }

    public function storeQuestions(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);

        if ($request->has('question_text')) {
            $request->validate([
                'question_text' => 'required|string',
                'type' => 'required|in:multiple_choice,essay',
                'options' => 'nullable|array',
                'correct_answer' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $request->hasFile('image') ? $request->file('image')->store('question_images', 'public') : null;
            $options = $request->type === 'multiple_choice' ? json_encode($request->options) : null;

            Question::create([
                'exam_id' => $exam->id,
                'question_text' => $request->question_text,
                'options' => $options,
                'correct_answer' => $request->correct_answer,
                'type' => $request->type,
                'image_path' => $imagePath,
            ]);

            return redirect()->route('guru.exams.show', $examId)->with('success', 'Soal berhasil ditambahkan!');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if (!in_array($extension, ['docx', 'xlsx'])) {
                return back()->with('error', 'Format file tidak didukung.');
            }

            $path = $file->store('uploads');

            if ($extension === 'docx') {
                try {
                    $this->processWord($path, $exam);
                } catch (\Exception $e) {
                    return back()->with('error', 'Terjadi kesalahan saat memproses file Word.');
                }
            } elseif ($extension === 'xlsx') {
                try {
                    $this->processExcel($path, $exam);
                } catch (\Exception $e) {
                    return back()->with('error', 'Terjadi kesalahan saat memproses file Excel.');
                }
            }

            return redirect()->route('guru.exams.show', $examId)->with('success', 'Soal berhasil diunggah!');
        }

        return back()->with('error', 'Harap isi form atau unggah file.');
    }

    public function editQuestions($examId)
    {
        $exam = Exam::with('soal')->findOrFail($examId); // Ambil ujian beserta soal-soalnya
        return view('guru.exams.edit_questions', compact('exam'));
    }

    public function updateQuestion(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);

        // Validasi input
        $validated = $request->validate([
            'soal_text' => 'required|string',
            'correct_answer' => 'nullable|string',
        ]);

        // Update soal teks dan jawaban benar
        $question->update([
            'question_text' => $validated['soal_text'],
            'correct_answer' => $validated['correct_answer'],
        ]);

        // Mengembalikan respons dengan data yang diperbarui
        return response()->json([
            'success' => true,
            'new_answer' => $question->correct_answer,
        ]);
    }

    // Menampilkan gambar soal yang ada (jika ada)
    public function showImage($questionId)
    {
        $question = Question::findOrFail($questionId);
        $exam = $question->exam;

        return view('guru.exams.edit_image', compact('question', 'exam'));
    }

    // Mengupdate gambar soal
    public function updateImage(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);

        // Validasi gambar
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        // Hapus gambar lama jika ada
        if ($question->image_path && Storage::exists('public/' . $question->image_path)) {
            Storage::delete('public/' . $question->image_path);
        }

        // Simpan gambar baru
        $imagePath = $request->file('image')->store('question_images', 'public');
        $question->update(['image_path' => $imagePath]);

        return redirect()->route('guru.exams.image', $questionId)->with('success', 'Gambar berhasil diperbarui.');
    }

    // Hapus soal langsung tanpa konfirmasi
    public function quickDeleteQuestion($examId, $questionId)
    {
        Question::where('exam_id', $examId)->findOrFail($questionId)->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }

    public function showStudentScores($examId)
    {
        // Ambil data ujian berdasarkan ID
        $exam = Exam::findOrFail($examId);

        // Ambil semua attempt ujian oleh siswa yang mengikuti ujian tersebut
        $examAttempts = ExamAttempt::with('user.kelas') // Memuat relasi kelas melalui pivot
            ->where('exam_id', $examId)
            ->get();

        return view('guru.exams.scores', compact('exam', 'examAttempts'));
    }

    private function processWord($path, $exam)
    {
        $phpWord = WordIOFactory::load(Storage::path($path));
        $text = '';
        $images = [];

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                            $text .= $textElement->getText() . "\n";
                        }
                    }
                } elseif ($element instanceof \PhpOffice\PhpWord\Element\Image) {
                    // Simpan gambar ke storage
                    $imageData = $element->getImageStringData();
                    $imageExtension = $element->getImageExtension();

                    $imageName = 'question_images/' . uniqid() . '.' . $imageExtension;
                    Storage::put("public/{$imageName}", base64_decode($imageData));

                    $images[] = $imageName; // Simpan path gambar
                }
            }
        }

        \Log::info("Isi Word File:\n" . $text);
        \Log::info("Total Gambar: " . count($images));

        // Perbaikan regex untuk menangkap soal dan jawaban
        $pattern = '/Pertanyaan:\s*(.*?)\n(?:A\.\s*(.*?)\nB\.\s*(.*?)\nC\.\s*(.*?)\nD\.\s*(.*?)\n)?Jawaban:\s*([A-D]?)/s';

        preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return back()->with('error', 'Format soal dalam file Word tidak dikenali.');
        }

        foreach ($matches as $index => $match) {
            try {
                $questionText = trim($match[1]);
                $correctAnswer = isset($match[6]) ? trim($match[6]) : null;

                $options = [];
                if (!empty($match[2]) && !empty($match[3]) && !empty($match[4]) && !empty($match[5])) {
                    $options = [
                        'A' => trim($match[2]),
                        'B' => trim($match[3]),
                        'C' => trim($match[4]),
                        'D' => trim($match[5]),
                    ];
                }

                $type = !empty($options) ? 'multiple_choice' : 'essay';

                // Jika soal essay, tidak perlu jawaban benar
                if ($type === 'essay') {
                    $correctAnswer = null;
                }

                // Pastikan gambar terkait soal dimasukkan ke database
                $imagePath = isset($images[$index]) ? $images[$index] : null;

                Question::create([
                    'exam_id' => $exam->id,
                    'question_text' => $questionText,
                    'options' => !empty($options) ? json_encode($options) : null,
                    'correct_answer' => $correctAnswer,
                    'type' => $type,
                    'image_path' => $imagePath, // Simpan gambar jika ada
                ]);
            } catch (\Exception $e) {
                \Log::error("Error memproses soal dari Word: " . $e->getMessage());
            }
        }
    }

    private function processExcel($path, $exam)
    {
        $spreadsheet = ExcelIOFactory::load(Storage::path($path));
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        \Log::info("Total Baris dalam Excel: " . count($data));

        foreach ($data as $index => $row) {
            if ($index == 0) {
                \Log::info("Skipping header row.");
                continue;
            }

            if (empty($row[0])) {
                \Log::warning("Skipping empty row at index: " . $index);
                continue;
            }

            try {
                $questionText = trim($row[0]);
                $optionsJson = $row[1];
                $correctAnswer = trim($row[2]);
                $type = trim($row[3]);
                $imageFileName = isset($row[4]) ? trim($row[4]) : null; // Nama file gambar

                \Log::info("Processing row $index: $questionText");

                $options = null;
                if ($type === 'multiple_choice') {
                    $options = json_decode($optionsJson, true);

                    if (!is_array($options)) {
                        throw new \Exception("Format opsi tidak valid di baris $index.");
                    }
                }

                if ($type === 'essay') {
                    $options = null;
                    $correctAnswer = null;
                }

                // Proses gambar
                $imagePath = null;
                if ($imageFileName) {
                    $originalPath = "uploads/excel_images/{$imageFileName}";
                    if (Storage::exists("public/{$originalPath}")) {
                        $newPath = 'question_images/' . uniqid() . '.' . pathinfo($imageFileName, PATHINFO_EXTENSION);
                        Storage::move("public/{$originalPath}", "public/{$newPath}");
                        $imagePath = $newPath;
                    } else {
                        \Log::warning("Gambar tidak ditemukan untuk soal: " . $questionText);
                    }
                }

                Question::create([
                    'exam_id' => $exam->id,
                    'question_text' => $questionText,
                    'options' => $options ? json_encode($options) : null,
                    'correct_answer' => $correctAnswer,
                    'type' => $type,
                    'image_path' => $imagePath, // Simpan gambar jika ada
                ]);
            } catch (\Exception $e) {
                \Log::error("Error processing row $index: " . $e->getMessage());
            }
        }
    }
}
