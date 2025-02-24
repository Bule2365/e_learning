<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run()
    {
        // Buat 50 ujian
        $exams = Exam::factory()->count(78)->create();

        // Hubungkan ujian dengan kelas, mata pelajaran, dan guru
        $classes = ClassModel::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'guru')->get();

        foreach ($exams as $exam) {
            $exam->class_id = $classes->random()->id; // Random kelas
            $exam->subject_id = $subjects->random()->id; // Random mata pelajaran
            $exam->user_id = $teachers->random()->id; // Random guru
            $exam->save();
        }
    }
}
