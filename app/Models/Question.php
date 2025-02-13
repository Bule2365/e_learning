<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_text',
        'options', // JSON field untuk pilihan ganda
        'correct_answer',
        'type',
    ];

    protected $casts = [
        'options' => 'array', // Cast JSON ke array
        'type' => 'string',   // Enum type: multiple_choice, essay
    ];

    // Relasi ke ujian (setiap soal terkait dengan satu ujian)
    public function ujian()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // Relasi ke jawaban ujian (soal bisa memiliki banyak jawaban yang diberikan oleh pengguna)
    public function jawaban()
    {
        return $this->hasMany(ExamAnswer::class, 'question_id');
    }
}