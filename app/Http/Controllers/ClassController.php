<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $classes = ClassModel::all();
            return view('admin.classes.index', compact('classes'));
        }

        if (Auth::user()->role == 'guru') {
            // $classes = ClassModel::whereHas('guru', function ($query) {
            //     $query->where('users.id', Auth::id());
            // })->get();
            $classes = ClassModel::all();
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
        // Validasi dengan pengecualian untuk ID kelas yang sedang diperbarui
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:classes,name,' . $id, // Menambahkan pengecualian untuk ID yang sedang diperbarui
            'deskripsi' => 'required|string',
        ]);
    
        // Temukan kelas berdasarkan ID dan perbarui
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
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berasil dihapus');
    }

    public function join($classId)
    {
        $user = Auth::user();
        $class = ClassModel::findOrFail($classId);
    
        // Cek jika siswa sudah tergabung di kelas ini
        if (!$user->kelas->contains($class)) {
            // Bergabungkan siswa dengan kelas
            $class->siswa()->attach($user->id);
            return redirect()->route('siswa.classes.index')->with('success', 'Anda berhasil bergabung dengan kelas.');
        }
    
        return redirect()->route('siswa.classes.index')->with('error', 'Anda sudah tergabung dengan kelas ini.');
    }    
}
