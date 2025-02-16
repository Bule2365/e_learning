<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'started_at',
        'submitted_at',
        'score',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'integer',
    ];

    // Relasi ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }    

    // Relasi ke percakapan ujian (jawaban terkait dengan upaya ujian tertentu)
    public function upayaUjian()
    {
        return $this->belongsTo(ExamAnswer::class, 'exam_attempt_id');
    }

    // Relasi ke soal (jawaban terkait dengan soal tertentu)
    public function soal()
    {
        return $this->belongsTo(Exam::class, 'question_id');
    }
}
