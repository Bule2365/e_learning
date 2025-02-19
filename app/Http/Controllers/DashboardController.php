<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard untuk admin
    public function adminDashboard()
    {
        // Ambil data untuk admin
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahKelas = ClassModel::count();  // Menampilkan jumlah kelas
        $jumlahMapel = Subject::count(); // Menampilkan jumlah mata pelajaran
    
        // Mengirim data ke view
        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahMapel'));
    }    

    // Dashboard untuk guru
    public function guruDashboard()
    {
        // Ambil data untuk guru
        $jumlahTugas = Task::where('user_id', auth()->user()->id)->count();

        return view('guru.dashboard', compact('jumlahTugas'));
    }

    public function siswaDashboard()
    {
        $siswa = auth()->user();
    
        // Mengambil kelas yang diikuti oleh siswa
        $kelasSiswa = $siswa->kelas; // Mengambil kelas melalui relasi pada User
        
        // Mengambil jumlah tugas berdasarkan kelas yang diikuti siswa
        $jumlahTugas = Task::whereHas('kelas', function ($query) use ($kelasSiswa) {
            $query->whereIn('id', $kelasSiswa->pluck('id'));
        })->count();
    
        return view('siswa.dashboard', compact('jumlahTugas'));
    }    
}
