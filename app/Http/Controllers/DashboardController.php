<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Material;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminDashboard(Request $request)
    {
        // Data umum
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahKelas = ClassModel::count();
        $jumlahMapel = Subject::count();
        $jumlahMateri = Material::count();
        $jumlahUjian = Exam::count();
        $jumlahTugas = Task::where('due_date', '>=', now())->count();

        // Hitung data bulan lalu
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = ($bulanLalu == 12) ? $tahunSekarang - 1 : $tahunSekarang;

        $jumlahSiswaBulanLalu = User::where('role', 'siswa')
            ->whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->count();
        $jumlahGuruBulanLalu = User::where('role', 'guru')
            ->whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->count();
        $jumlahKelasBulanLalu = ClassModel::whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->count();
        $jumlahMapelBulanLalu = Subject::whereMonth('created_at', $bulanLalu)
            ->whereYear('created_at', $tahunLalu)
            ->count();

        // Fungsi untuk menghitung persentase perubahan
        function hitungPersentase($sekarang, $bulanLalu)
        {
            if ($bulanLalu == 0) {
                return $sekarang > 0 ? 100 : 0;
            }
            return round((($sekarang - $bulanLalu) / $bulanLalu) * 100, 1);
        }

        $persenSiswa = hitungPersentase($jumlahSiswa, $jumlahSiswaBulanLalu);
        $persenGuru = hitungPersentase($jumlahGuru, $jumlahGuruBulanLalu);
        $persenKelas = hitungPersentase($jumlahKelas, $jumlahKelasBulanLalu);
        $persenMapel = hitungPersentase($jumlahMapel, $jumlahMapelBulanLalu);

        // Ambil semua data siswa & guru dari semua tahun
        $data = User::whereIn('role', ['siswa', 'guru'])
            ->selectRaw('YEAR(created_at) as year, role, COUNT(*) as total')
            ->groupBy('year', 'role')
            ->orderBy('year')
            ->get();

        // Ambil semua tahun yang ada di data
        $years = User::selectRaw("YEAR(created_at) as year")
            ->distinct()
            ->orderBy('year')
            ->pluck('year')
            ->all();

        // Siapkan array dengan default 0
        $dataSiswa = array_fill_keys($years, 0);
        $dataGuru = array_fill_keys($years, 0);

        // Isi data dengan jumlah siswa & guru berdasarkan tahun
        foreach ($data as $item) {
            $yearKey = $item->year; // Tidak perlu format "2023/2024"
            if ($item->role == 'siswa') {
                $dataSiswa[$yearKey] = $item->total;
            } elseif ($item->role == 'guru') {
                $dataGuru[$yearKey] = $item->total;
            }
        }

        // Top 5 Guru dengan Materi Terbanyak
        $topGuruMateri = User::where('role', 'guru')
            ->withCount('materials')
            ->orderByDesc('materials_count')
            ->limit(5)
            ->get();

        // Top 5 Materi
        $topMateri = Material::select('id', 'title', 'class_id', 'created_at', DB::raw('COUNT(class_id) as class_count'))
            ->with('classModel')
            ->groupBy('id', 'title', 'class_id', 'created_at') // Tambahkan 'created_at' dalam GROUP BY
            ->orderByDesc('created_at') // Pastikan sorting berdasarkan tanggal
            ->limit(5)
            ->get();    

        // Rata-rata nilai ujian per mata pelajaran
        $rataNilaiUjian = Exam::with('upayaUjian')
            ->get()
            ->mapWithKeys(function ($exam) {
                return [$exam->title => $exam->upayaUjian->avg('score') ?? 0];
            });

        return view('admin.dashboard', compact(
            'jumlahSiswa',
            'jumlahGuru',
            'jumlahKelas',
            'jumlahMapel',
            'jumlahMateri',
            'jumlahUjian',
            'jumlahTugas',
            'years',
            'dataSiswa',
            'dataGuru',
            'topMateri',
            'rataNilaiUjian',
            'topGuruMateri',
            'persenSiswa',
            'persenGuru',
            'persenKelas',
            'persenMapel'
        ));
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
