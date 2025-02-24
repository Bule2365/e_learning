<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     // Ambil semua guru dari database
    //     $gurus = User::where('role', 'guru')->get();

    //     // Daftar mata pelajaran yang ingin dibuat
    //     $subjects = ['PAI', 'PKN', 'DKV', 'IPA', 'MTK', 'TKJ'];

    //     // Acak urutan mata pelajaran
    //     shuffle($subjects);

    //     // Pastikan jumlah guru cukup untuk jumlah mata pelajaran
    //     if ($gurus->count() < count($subjects)) {
    //         // Jika jumlah guru lebih sedikit, ulangi guru yang ada untuk diberikan beberapa mata pelajaran
    //         $gurus = $gurus->concat($gurus->take(count($subjects) - $gurus->count()));
    //     }

    //     // Distribusikan mata pelajaran ke guru secara acak
    //     foreach ($subjects as $index => $subject) {
    //         Subject::create([
    //             'name' => $subject,
    //             'user_id' => $gurus[$index % $gurus->count()]->id, // Menggunakan modulo untuk mengulang guru jika jumlah guru kurang
    //         ]);
    //     }
    // }

    public function run()
    {
        // Buat 15 mata pelajaran
        $subjects = Subject::factory()->count(15)->create();

        // Hubungkan mata pelajaran dengan guru
        $teachers = User::where('role', 'guru')->get();
        foreach ($subjects as $subject) {
            $subject->guru()->associate($teachers->random()); // Random guru per mata pelajaran
            $subject->save();
        }
    }
}
