<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Material;
use App\Models\Question;
use App\Models\Task;
use App\Models\TaskUser;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_users()
    {
        User::factory(10)->create();
        $this->assertDatabaseCount('users', 10);
    }

    /** @test */
    public function it_has_classes()
    {
        ClassModel::factory(3)->create();
        $this->assertDatabaseCount('classes', 3);
    }

    /** @test */
    public function it_has_subjects()
    {
        Subject::factory(5)->create();
        $this->assertDatabaseCount('subjects', 5);
    }

    /** @test */
    public function it_has_exams()
    {
        Exam::factory(5)->create();
        $this->assertDatabaseCount('exams', 5);
    }

    /** @test */
    public function it_has_questions()
    {
        Question::factory(20)->create();
        $this->assertDatabaseCount('questions', 20);
    }

    /** @test */
    public function it_has_exam_attempts()
    {
        ExamAttempt::factory(10)->create();
        $this->assertDatabaseCount('exam_attempts', 10);
    }

    /** @test */
    public function it_has_exam_answers()
    {
        ExamAnswer::factory(50)->create();
        $this->assertDatabaseCount('exam_answers', 50);
    }

    /** @test */
    public function it_has_materials()
    {
        Material::factory(10)->create();
        $this->assertDatabaseCount('materials', 10);
    }

    /** @test */
    public function it_has_tasks()
    {
        Task::factory(10)->create();
        $this->assertDatabaseCount('tasks', 10);
    }

    /** @test */
    public function it_has_task_users()
    {
        TaskUser::factory(30)->create();
        $this->assertDatabaseCount('task_user', 30);
    }
}
