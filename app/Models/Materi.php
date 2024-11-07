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
        'url',
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


}
