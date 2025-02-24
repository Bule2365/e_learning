<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ClassModel;
use App\Models\Exam;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_exam_list()
    {
        $class = ClassModel::factory()->create();
        $exam = Exam::factory()->create(['class_id' => $class->id]);

        $response = $this->get(route('admin.exams.byClass', ['classId' => $class->id]));

        $response->assertStatus(200);
        $response->assertSee($exam->title);
    }

    public function test_no_exams_message_is_shown_when_no_exams_exist()
    {
        $class = ClassModel::factory()->create();

        $response = $this->get(route('admin.exams.byClass', ['classId' => $class->id]));

        $response->assertStatus(200);
        $response->assertSee('Belum ada ujian tersedia di kelas ini.');
    }
}
