<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relasi ke ujian (setiap upaya ujian terkait dengan satu ujian)
    public function ujian()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // Relasi ke jawaban ujian (setiap upaya ujian bisa memiliki banyak jawaban)
    public function jawaban()
    {
        return $this->hasMany(ExamAnswer::class, 'exam_attempt_id');
    }

    // Relasi ke tabel ExamAttempts
    public function upaya()
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    // Relasi ke tabel Questions
    public function soal()
    {
        return $this->belongsTo(Question::class);
    }
}
