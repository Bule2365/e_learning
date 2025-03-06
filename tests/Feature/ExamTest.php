<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Exam;
use App\Models\ClassModel;
use App\Models\Subject;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_can_list_exams()
    {
        $user = User::factory()->create([
            'role' => 'guru' // Pastikan peran sesuai dengan middleware
        ]);

        \Log::info(Exam::all());

        $this->actingAs($user); // Simulasikan user yang login

        Exam::factory()->count(3)->create();

        $response = $this->get('/guru/exams');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_an_exam()
    {
        $user = User::factory()->create();
        $class = ClassModel::factory()->create();
        $subject = Subject::factory()->create();

        $exam = Exam::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'title' => 'Ujian Matematika',
            'description' => 'Deskripsi ujian',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('exams', ['title' => 'Ujian Matematika']);
    }

    /** @test */
    public function it_can_update_an_exam()
    {
        $exam = Exam::factory()->create(['title' => 'Ujian Lama']);

        $exam->update(['title' => 'Ujian Baru']);

        $this->assertDatabaseHas('exams', ['title' => 'Ujian Baru']);
    }

    /** @test */
    public function it_can_delete_an_exam()
    {
        $exam = Exam::factory()->create();

        $exam->delete();

        $this->assertDatabaseMissing('exams', ['id' => $exam->id]);
    }

    /** @test */
    public function it_can_list_exams()
    {
        Exam::factory()->count(3)->create();

        $response = $this->get('/guru/exams');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_change_exam_status_to_draft()
    {
        $exam = Exam::factory()->create(['status' => 'published']);

        $exam->update(['status' => 'draft']);

        $this->assertDatabaseHas('exams', ['id' => $exam->id, 'status' => 'draft']);
    }
}
