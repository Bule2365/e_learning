<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['title', 'description', 'file_path', 'subject_id', 'class_id', 'user_id', 'due_date'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function kelas()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
            ->withPivot('submission', 'score');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('score');
    }
}
