<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['assignments_file', 'materi_id','assignments_type','assignments_link','assignments_content',];

    // Define relationship to Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function mataPelajaran()
{
    return $this->belongsTo(MataPelajaran::class);
}

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
