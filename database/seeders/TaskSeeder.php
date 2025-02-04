<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // Ambil semua kelas dan mata pelajaran
        // $kelas = ClassModel::all();
        // $subjects = Subject::all();
        // $users = User::where('role', 'guru')->get();

        // // Setiap guru akan memberikan tugas
        // foreach ($users as $guru) {
        //     foreach ($subjects as $subject) {
        //         // Tentukan kelas yang akan diberikan tugas
        //         foreach ($kelas as $class) {
        //             // Tambahkan tugas
        //             Task::create([
        //                 'title' => 'Tugas ' . $subject->name . ' - ' . $class->name,
        //                 'description' => 'Deskripsi Tugas ' . $subject->name . ' untuk kelas ' . $class->name,
        //                 'file_path' => null, // Bisa diisi file jika ada
        //                 'subject_id' => $subject->id,
        //                 'class_id' => $class->id,
        //                 'user_id' => $guru->id,
        //                 'due_date' => now()->addDays(7),
        //             ]);
        //         }
        //     }
        // }
    }
}
