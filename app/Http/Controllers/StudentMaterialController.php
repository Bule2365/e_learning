<?php
namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Subject;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StudentMaterialController extends Controller
{
    public function index()
    {
        // Ambil semua mata pelajaran
        $subjects = Subject::all();
    
        // Ambil ID kelas yang diikuti oleh siswa
        $classIds = DB::table('class_user')
                      ->where('user_id', Auth::id())
                      ->pluck('class_id');
    
        // Tambahkan jumlah materi ke setiap mata pelajaran
        foreach ($subjects as $subject) {
            $subject->material_count = Material::where('subject_id', $subject->id)
                                               ->whereIn('class_id', $classIds)
                                               ->count();
        }
    
        return view('siswa.material.index', compact('subjects'));
    }    

    public function showMaterials($subject_id)
    {
        // Ambil semua kelas yang terkait dengan siswa
        $classIds = DB::table('class_user')
                      ->where('user_id', Auth::id())
                      ->pluck('class_id');
    
        // Ambil materi berdasarkan subject dan kelas siswa
        $materials = Material::where('subject_id', $subject_id)
                             ->whereIn('class_id', $classIds) // Filter berdasarkan kelas siswa
                             ->get();
    
        // Decode file_path jika disimpan dalam JSON
        foreach ($materials as $material) {
            $material->file_paths = json_decode($material->file_path, true) ?? [];
        }
    
        return view('siswa.material.list', compact('materials'));
    }

    public function showMaterialDetail($id)
    {
        // Ambil materi berdasarkan ID
        $material = Material::findOrFail($id);
    
        // Ambil semua kelas yang terkait dengan siswa
        $classIds = DB::table('class_user')
                      ->where('user_id', Auth::id())
                      ->pluck('class_id');
    
        // Pastikan materi ada di salah satu kelas siswa
        if (!in_array($material->class_id, $classIds->toArray())) {
            return redirect()->route('siswa.material.index')->with('error', 'Anda tidak memiliki akses ke materi ini.');
        }
    
        // Decode file_path jika disimpan dalam JSON
        $material->file_paths = json_decode($material->file_path, true) ?? [];
    
        // Rekomendasi materi lain dari subject yang sama
        $recommendedMaterials = Material::where('subject_id', $material->subject_id)
                                        ->where('id', '!=', $id)
                                        ->whereIn('class_id', $classIds) // Filter berdasarkan kelas siswa
                                        ->inRandomOrder()
                                        ->limit(5)
                                        ->get();
    
        foreach ($recommendedMaterials as $recMaterial) {
            $recMaterial->file_paths = json_decode($recMaterial->file_path, true) ?? [];
        }
    
        return view('siswa.material.detail', compact('material', 'recommendedMaterials'));
    }
}
