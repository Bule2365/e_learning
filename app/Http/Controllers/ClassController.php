<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            // Admin bisa melihat semua kelas dan semua pengguna (guru dan siswa)
            $classes = ClassModel::all();
            $users = User::all();
            return view('admin.classes.index', compact('classes', 'users'));
        }

        if (Auth::user()->role == 'guru') {
            // Guru bisa melihat semua kelas, baik yang diajarkan oleh mereka maupun yang tidak
            // Pertama-tama, kita ambil semua kelas yang ada
            $classes = ClassModel::all();

            // Kemudian filter kelas yang diajarkan oleh guru saat ini (jika ada)
            $myClasses = ClassModel::whereHas('guru', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();

            return view('guru.classes.index', compact('classes', 'myClasses'));
        }

        $user = Auth::user();

        if ($user->classes()->count() > 0) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah bergabung dengan kelas.');
        }

        $classes = ClassModel::whereDoesntHave('siswa', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('siswa.classes.index', compact('classes'));
    }

    public function create()
    {
        $users = User::where('role', 'guru')->get();
        return view('admin.classes.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('classes'),
            ],
            'deskripsi' => 'required|string',
            'guru_id' => 'required|exists:users,id', // Validasi guru_id untuk memastikan guru valid
        ]);

        // Membuat kelas terlebih dahulu
        $class = ClassModel::create([
            'name' => $validatedData['name'],
            'deskripsi' => $validatedData['deskripsi'],
        ]);

        // Setelah kelas dibuat, tambahkan guru ke kelas
        if ($request->has('guru_id')) {
            $class->guru()->attach($validatedData['guru_id']);
        }

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dibuat dan guru telah ditambahkan!');
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        $users = User::where('role', 'guru')->get();
        return view('admin.classes.edit', compact('class', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('classes')->ignore($id),
            ],
            'deskripsi' => 'required|string',
            'guru_id' => 'required|array', // Pastikan ini berupa array
            'guru_id.*' => 'exists:users,id', // Validasi ID guru
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update([
            'name' => $validatedData['name'],
            'deskripsi' => $validatedData['deskripsi'],
        ]);

        // Sinkronkan ID guru yang dipilih
        $class->guru()->sync($validatedData['guru_id']);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->guru()->detach();
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function join($classId)
    {
        $user = Auth::user();
        $class = ClassModel::findOrFail($classId);

        if ($user->classes()->count() > 0) {
            return redirect()->route('siswa.dashboard')->with('info', 'Anda sudah bergabung dengan kelas.');
        }

        $class->siswa()->attach($user->id);

        return redirect()->route('siswa.classes.index')->with('success', 'Anda berhasil bergabung dengan kelas.');
    }
}
