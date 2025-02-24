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
        // $mataPelajarans = Subject::all();
        // $users = User::where('role', 'guru')->get();

        // // Setiap guru akan memberikan tugas
        // foreach ($users as $guru) {
        //     foreach ($mataPelajarans as $mataPelajaran) {
        //         // Tentukan kelas yang akan diberikan tugas
        //         foreach ($kelas as $class) {
        //             // Tambahkan tugas
        //             Task::create([
        //                 'title' => 'Tugas ' . $mataPelajaran->name . ' - ' . $class->name,
        //                 'description' => 'Deskripsi Tugas ' . $mataPelajaran->name . ' untuk kelas ' . $class->name,
        //                 'file_path' => null, // Bisa diisi file jika ada
        //                 'subject_id' => $mataPelajaran->id,
        //                 'class_id' => $class->id,
        //                 'user_id' => $guru->id,
        //                 'due_date' => now()->addDays(7),
        //             ]);
        //         }
        //     }
        // }

        // Buat 60 tugas
        $tasks = Task::factory()->count(60)->create();

        // Hubungkan tugas dengan kelas, mata pelajaran, dan guru
        $classes = ClassModel::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'guru')->get();

        foreach ($tasks as $task) {
            $task->class_id = $classes->random()->id; // Random kelas
            $task->subject_id = $subjects->random()->id; // Random mata pelajaran
            $task->user_id = $teachers->random()->id; // Random guru
            $task->save();
        }
    }
}
