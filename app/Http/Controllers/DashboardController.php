<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahMapel = Subject::count();

        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahMapel'));
    }
}
