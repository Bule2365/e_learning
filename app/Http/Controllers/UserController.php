<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        // Menyembunyikan admin dari daftar pengguna
        $query = User::where('role', '!=', 'admin');

        // Pencarian berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan role (tanpa admin)
        if ($request->has('role') && $request->role != '' && $request->role != 'admin') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(35);

        return view('admin.users.index', compact('users'));
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
        return redirect()->back()->with('success', 'Pengguna terpilih berhasil dihapus.');
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

        // Cek jika file ada
        if (!$request->hasFile('file')) {
            return back()->withErrors(['file' => 'File tidak ditemukan.']);
        }

        // Ambil file yang diupload
        $file = $request->file('file');

        // Cek apakah file bisa dibaca
        try {
            $handle = fopen($file->getPathname(), 'r');
            if (!$handle) {
                return back()->withErrors(['file' => 'Gagal membuka file. Pastikan file CSV valid.']);
            }

            // Lewati header CSV
            $header = fgetcsv($handle);
            if ($header === false) {
                return back()->withErrors(['file' => 'Gagal membaca header file CSV.']);
            }

            // Proses data CSV
            $failedImports = 0; // Menyimpan jumlah gagal impor
            $successfulImports = 0; // Menyimpan jumlah sukses impor
            $failedRows = []; // Menyimpan baris yang gagal
            $failedEmails = []; // Menyimpan email yang sudah ada

            while (($row = fgetcsv($handle)) !== false) {
                // Pengecekan apakah baris memiliki data yang valid
                if (count($row) < 3) {  // Jika baris tidak memiliki cukup kolom
                    $failedImports++;
                    $failedRows[] = $row; // Catat baris yang gagal
                    continue; // Lewati baris yang tidak valid
                }

                $name = $row[0];  // Kolom pertama untuk nama
                $email = $row[1];  // Kolom kedua untuk email
                $role = $row[2];  // Kolom ketiga untuk role

                // Validasi role
                if (!in_array($role, ['admin', 'guru', 'siswa'])) {
                    $failedImports++;
                    $failedRows[] = $row; // Catat baris yang gagal
                    continue; // Lewati baris yang role-nya tidak valid
                }

                // Cek jika email sudah ada
                if (User::where('email', $email)->exists()) {
                    // Catat email yang sudah ada
                    $failedEmails[] = $email;
                    $failedImports++;
                    continue; // Lewati baris yang email-nya sudah ada
                }

                try {
                    // Menyisipkan atau memperbarui pengguna
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => bcrypt('password'), // Password default
                        'role' => $role,
                    ]);
                    $successfulImports++;
                } catch (\Exception $e) {
                    // Tangani error jika ada kesalahan dalam proses penyimpanan
                    $failedImports++;
                    $failedRows[] = $row; // Catat baris yang gagal
                    continue; // Lewati baris yang gagal
                }
            }

            fclose($handle);

            // Berikan respons berdasarkan jumlah impor yang berhasil dan gagal
            if ($failedImports > 0) {
                // Logging baris yang gagal untuk analisis lebih lanjut
                logger()->error("Gagal mengimpor pengguna:", ['failedRows' => $failedRows, 'failedEmails' => $failedEmails]);

                // Menggabungkan informasi baris yang gagal
                $failedUserDetails = [];
                foreach ($failedRows as $row) {
                    $failedUserDetails[] = "Name: {$row[0]}, Email: {$row[1]}, Role: {$row[2]}";
                }

                $failedEmailDetails = [];
                foreach ($failedEmails as $email) {
                    $failedEmailDetails[] = "Email sudah terdaftar: $email";
                }

                return redirect()->route('users.index')->with('error', "$failedImports pengguna gagal diimpor. Berikut adalah detailnya: " . implode('; ', $failedUserDetails) . " " . implode('; ', $failedEmailDetails));
            }

            return redirect()->route('users.index')->with('success', "$successfulImports pengguna berhasil diimpor.");
        } catch (\Exception $e) {
            // Tangani kesalahan yang tidak terduga
            return back()->withErrors(['file' => 'Terjadi kesalahan saat memproses file. Pesan error: ' . $e->getMessage()]);
        }
    }
}
