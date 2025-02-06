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
    public function run()
    {
    //     // Ambil guru pertama yang akan mengajar semua mata pelajaran
    //     $guru = User::where('role', 'guru')->first();

    //     // Daftar mata pelajaran yang ingin dibuat
    //     $subjects = ['PAI', 'PKN', 'DKV', 'IPA', 'MTK', 'TKJ'];

    //     foreach ($subjects as $subject) {
    //         Subject::create([
    //             'name' => $subject,
    //             'user_id' => $guru->id, // Asumsikan guru pertama mengajar semua mata pelajaran
    //         ]);
    //     }
    // }
    }
}
