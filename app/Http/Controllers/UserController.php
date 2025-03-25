<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        $query = User::query();
    
        // Ambil tahun terbaru dari data siswa yang ada
        $latestYear = User::where('role', 'siswa')
            ->orderBy('created_at', 'desc')
            ->value(DB::raw('YEAR(created_at)'));
    
        // Ambil daftar tahun yang tersedia untuk siswa
        $availableYears = User::where('role', 'siswa')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');
    
        // **Default peran yang ditampilkan saat pertama kali adalah siswa**
        $selectedRole = $request->has('role') ? $request->role : 'siswa';
    
        // **Default tahun adalah tahun terbaru (jika siswa yang dipilih)**
        $selectedYear = ($selectedRole == 'siswa' && $request->has('tahun')) ? $request->tahun : $latestYear;
    
        // Filter berdasarkan peran (Admin tidak ditampilkan)
        $query->where('role', '!=', 'admin');
    
        // **Filter Peran (Siswa / Guru)**
        if ($selectedRole == 'siswa') {
            $query->where('role', 'siswa')->whereYear('created_at', $selectedYear);
        } elseif ($selectedRole == 'guru') {
            $query->where('role', 'guru'); // Guru tidak memiliki filter tahun
        }
    
        // **Filter Nama (search)**
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // **Ambil data pengguna**
        $users = $query->paginate(30);
    
        return view('admin.users.index', compact('users', 'availableYears', 'selectedYear', 'selectedRole'));
    }

    // Menampilkan form untuk membuat pengguna baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $this->validateRequest($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User  created successfully.');
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui pengguna
    public function update(Request $request, User $user)
    {
        // Validasi input
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,guru,siswa',
        ];

        // Tambahkan validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User  updated successfully.');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User  deleted successfully.');
    }

    // Validasi request
    protected function validateRequest(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email' . ($userId ? ",$userId" : ''),
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa',
        ];

        $request->validate($rules);
    }

    public function export()
    {
        $users = User::all();

        // Nama file CSV
        $filename = 'users.csv';

        // Header untuk respons
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        // Mengembalikan response dengan file CSV
        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            // Menulis header CSV
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Created At', 'Updated At']);

            // Menulis data setiap user ke CSV
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at,
                    $user->updated_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:10240',
        ]);

        // Debugging: cek apakah file diterima
        if (!$request->hasFile('file')) {
            return back()->withErrors(['file' => 'File tidak ditemukan.']);
        }

        $file = $request->file('file');

        // Debugging: tampilkan informasi file
        logger('File diterima: ' . $file->getClientOriginalName());

        // Membaca file CSV
        $handle = fopen($file->getPathname(), 'r');
        if (!$handle) {
            return back()->withErrors(['file' => 'Gagal membaca file.']);
        }

        // Lewati header CSV
        $header = fgetcsv($handle);

        // Debugging: tampilkan header CSV
        logger('Header CSV: ' . implode(', ', $header));

        // Proses data CSV
        while (($row = fgetcsv($handle)) !== false) {
            // Debugging: tampilkan baris CSV
            logger('Baris CSV: ' . implode(', ', $row));

            User::updateOrCreate(
                ['email' => $row[2]], // Identifier unik
                [
                    'name' => $row[1],
                    'email' => $row[2],
                    'password' => bcrypt('password'),
                    'role' => $row[3],
                ]
            );
        }

        fclose($handle);

        return redirect()->route('users.index')->with('success', 'Users imported successfully.');
    }
}
