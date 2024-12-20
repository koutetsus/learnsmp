<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'type',
        'file',
        'url',
        'link',
        'teacher_id',
        'mata_pelajaran_id',  // Add this line
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function mataPelajaran()
{
    return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
}

    // Relasi satu ke banyak dengan Assignment
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }




}
