<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use HasFactory;

    protected $table = 'task_user';

    protected $fillable = ['task_id', 'user_id', 'submission', 'score'];

    public function tugas()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
