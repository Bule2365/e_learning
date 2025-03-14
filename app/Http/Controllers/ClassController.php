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
    public function show($id)
    {
        $class = ClassModel::with('siswa')->findOrFail($id);

        // Ambil siswa yang belum masuk kelas
        $siswaBelumMasuk = User::where('role', 'siswa')
            ->leftJoin('class_user', 'users.id', '=', 'class_user.user_id')
            ->whereNull('class_user.user_id') // Hanya siswa yang belum memiliki kelas
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        return view('admin.classes.show', compact('class', 'siswaBelumMasuk'));
    }

    // Menambahkan siswa ke kelas
    public function addStudentToClass(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $user = User::findOrFail($request->user_id);

        if (Auth::user()->role == 'admin') {
            if (!$class->siswa->contains($user)) {
                $class->siswa()->attach($user->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Siswa berhasil ditambahkan.',
                    'student' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'Siswa sudah ada di kelas ini.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Hanya admin yang dapat menambahkan siswa.']);
    }

    // Mengeluarkan siswa dari kelas
    public function removeStudentFromClass(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $user = User::findOrFail($request->user_id);

        if (Auth::user()->role == 'admin') {
            if ($class->siswa->contains($user)) {
                $class->siswa()->detach($user->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Siswa berhasil dihapus.',
                    'student_id' => $user->id
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan dalam kelas ini.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Hanya admin yang dapat menghapus siswa.']);
    }
}
