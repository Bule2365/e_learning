<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    use HasFactory;

    protected $fillable = ['class_id', 'subject_id'];

    // Relasi ke Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Class (kelas)
    public function class()
    {
        return $this->belongsTo(ClassModel::class);  // Asumsi ada model Class
    }
}