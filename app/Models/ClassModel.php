<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'deskripsi'];

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')->where('role', 'siswa');
    }

    public function guru()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')->where('role','guru');
    }
}
