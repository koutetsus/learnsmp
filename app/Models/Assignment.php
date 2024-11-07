<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['file', 'materi_id'];

    // Define relationship to Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
