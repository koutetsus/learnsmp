<?php

// app/Models/MataPelajaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = ['name'];

    public function materis()
    {
        return $this->hasMany(Materi::class, 'mata_pelajaran_id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'mata_pelajaran_id');
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
