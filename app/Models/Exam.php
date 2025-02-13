<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Enum status: draft, published
    ];

    // Relasi ke tabel Class (asumsi ada model Class)
    public function kelas()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relasi ke mata pelajaran (setiap ujian terkait dengan satu mata pelajaran)
    public function mataPelajaran()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relasi ke soal ujian (setiap ujian memiliki banyak soal)
    public function soal()
    {
        return $this->hasMany(Question::class, 'exam_id');
    }

    // Relasi ke upaya ujian (setiap ujian bisa memiliki banyak percakapan atau upaya dari pengguna)
    public function upayaUjian()
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }
}
