<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $classes = ClassModel::all();
            return view('admin.classes.index', compact('classes'));
        }

        if (Auth::user()->role == 'guru') {
            $classes = ClassModel::all(); // Mengambil kelas yang diajarkan oleh guru
            return view('guru.classes.index', compact('classes'));
        }

        $user = Auth::user();
        $classes = ClassModel::whereDoesntHave('siswa', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('siswa.classes.index', compact('classes', 'user'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.classes.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:classes',
            'deskripsi' => 'required|string',
        ]);

        $class = ClassModel::create([
            'name' => $validatedData['name'],
            'deskripsi' => $validatedData['deskripsi'],
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dibuat!');
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:classes,name,' . $id,
            'deskripsi' => 'required|string',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->name = $request->name;
        $class->deskripsi = $request->deskripsi;
        $class->save();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus');
    }

    public function join($classId)
    {
        $user = Auth::user();
        $class = ClassModel::findOrFail($classId);

        if (!$user->kelas->contains($class)) {
            $class->siswa()->attach($user->id);
            return redirect()->route('siswa.classes.index')->with('success', 'Anda berhasil bergabung dengan kelas.');
        }

        return redirect()->route('siswa.classes.index')->with('error', 'Anda sudah tergabung dengan kelas ini.');
    }

    // Menampilkan detail kelas dan daftar siswa yang tergabung
    public function show($classId)
    {
        $class = ClassModel::with('siswa')->findOrFail($classId); // Mengambil kelas dan siswa yang tergabung
        $users = User::all();
        return view('admin.classes.show', compact('class', 'users'));
    }

    // Menambahkan siswa ke kelas
    public function addStudentToClass(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $user = User::findOrFail($request->user_id); // Mengambil ID siswa yang akan ditambahkan

        // Pastikan hanya admin yang bisa menambah siswa ke kelas
        if (Auth::user()->role == 'admin') {
            // Periksa apakah siswa sudah ada dalam kelas ini
            if (!$class->siswa->contains($user)) {
                $class->siswa()->attach($user->id);
                return redirect()->route('admin.classes.show', $classId)->with('success', 'Siswa berhasil ditambahkan ke kelas.');
            }
            return redirect()->route('admin.classes.show', $classId)->with('error', 'Siswa sudah tergabung di kelas ini.');
        }

        return redirect()->route('admin.classes.index')->with('error', 'Hanya admin yang bisa menambahkan siswa.');
    }

    // Mengeluarkan siswa dari kelas
    public function removeStudentFromClass(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $user = User::findOrFail($request->user_id); // Mengambil ID siswa yang akan dikeluarkan

        // Pastikan hanya admin yang bisa mengeluarkan siswa dari kelas
        if (Auth::user()->role == 'admin') {
            // Periksa apakah siswa ada dalam kelas ini
            if ($class->siswa->contains($user)) {
                $class->siswa()->detach($user->id);
                return redirect()->route('admin.classes.show', $classId)->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
            }
            return redirect()->route('admin.classes.show', $classId)->with('error', 'Siswa tidak ditemukan dalam kelas ini.');
        }

        return redirect()->route('admin.classes.index')->with('error', 'Hanya admin yang bisa mengeluarkan siswa.');
    }
}
