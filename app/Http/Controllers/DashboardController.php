<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Material;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    // Dashboard untuk admin
    public function adminDashboard()
    {
        // Data umum
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahKelas = ClassModel::count();
        $jumlahMapel = Subject::count();

        // Data perbandingan jumlah siswa dan guru berdasarkan tahun
        $data = User::select(DB::raw('YEAR(created_at) as year'), 'role', DB::raw('COUNT(*) as total'))
            ->whereIn('role', ['siswa', 'guru'])
            ->groupBy('year', 'role')
            ->get();

        // Mengelompokkan data berdasarkan tahun
        $years = $data->pluck('year')->unique()->sort()->values();
        $dataSiswa = $years->map(function ($year) use ($data) {
            return $data->where('year', $year)->where('role', 'siswa')->first()->total ?? 0;
        });

        $dataGuru = $years->map(function ($year) use ($data) {
            return $data->where('year', $year)->where('role', 'guru')->first()->total ?? 0;
        });

        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahMapel', 'years', 'dataSiswa', 'dataGuru'));
    }

    // Dashboard untuk guru
    public function guruDashboard()
    {
        // Ambil data untuk jumlah tugas dan ujian
        $jumlahMateri = Material::where('user_id', auth()->user()->id)->count();
        $jumlahTugas = Task::where('user_id', auth()->user()->id)->count();
        $jumlahUjian = Exam::where('user_id', auth()->user()->id)->count();  // Pastikan model Exam ada dan sesuai dengan database Anda

        return view('guru.dashboard', compact('jumlahTugas', 'jumlahUjian', 'jumlahMateri'));
    }

    public function siswaDashboard()
    {
        $siswa = auth()->user();

        // Mengambil kelas yang diikuti oleh siswa
        $kelasSiswa = $siswa->kelas;

        // Mengambil data tugas yang sudah diberikan kepada siswa berdasarkan kelas yang diikuti
        $tasks = Task::whereHas('kelas', function ($query) use ($kelasSiswa) {
            $query->whereIn('id', $kelasSiswa->pluck('id'));
        })->get();

        // Mengambil nilai tugas siswa melalui relasi pivot 'task_user'
        $taskScores = $tasks->map(function ($task) use ($siswa) {
            // Mengambil nilai tugas siswa dari pivot
            $taskUser = $task->users()->where('user_id', $siswa->id)->first();
            return [
                'id' => $task->id, // ID tugas
                'score' => $taskUser ? $taskUser->pivot->score : 0, // Nilai tugas atau 0 jika belum dikerjakan
            ];
        });

        // Mengambil nilai ujian siswa
        $examScores = ExamAttempt::where('exam_attempts.user_id', $siswa->id)
            ->join('exams', 'exams.id', '=', 'exam_attempts.exam_id') // Mengambil ujian yang diikuti oleh siswa
            ->select('exam_attempts.exam_id', 'exam_attempts.score')
            ->get();

        // Menyiapkan data untuk grafik
        $taskValues = $taskScores->pluck('score'); // Nilai tugas
        $examValues = $examScores->pluck('score'); // Nilai ujian

        // Ambil data mata pelajaran beserta tugas yang terkait
        $subjects = Subject::withCount('tugas') // Menambahkan jumlah tugas pada setiap mata pelajaran
            ->with('guru') // Mengambil data guru yang mengajar mata pelajaran tersebut
            ->get();

        // Mengirim data ke view
        return view('siswa.dashboard', compact('taskValues', 'examValues', 'subjects'));
    }
}
