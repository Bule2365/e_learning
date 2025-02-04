<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     // Ambil semua siswa
    //     $siswa = User::where('role', 'siswa')->get();

    //     // Ambil semua tugas
    //     $tasks = Task::all();

    //     // Assign tugas ke siswa (misalnya, setiap siswa mengambil 1 tugas dari masing-masing mata pelajaran)
    //     foreach ($siswa as $s) {
    //         foreach ($tasks as $task) {
    //             // Assign siswa ke tugas, bisa juga ditambahkan jawaban dan nilai jika ada
    //             $task->users()->attach($s->id, [
    //                 'submission' => 'Jawaban ' . $s->name . ' untuk tugas ' . $task->title,
    //                 'score' => rand(60, 100), // Nilai acak antara 60-100
    //             ]);
    //         }
    //     }
    // }
}
