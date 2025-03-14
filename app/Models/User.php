<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(ClassModel::class, 'class_user', 'user_id', 'class_id');
    }

    // Relasi many-to-many dengan ClassModel
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_user', 'user_id', 'class_id');
    }

    public function mataPelajaran()
    {
        return $this->hasMany(Subject::class);
    }

    public function tugas()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('score');
    }

    public function ujian()
    {
        return $this->belongsToMany(Exam::class, 'exam_attempts');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
}
