<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;


    protected $fillable = ['assignment_id', 'user_id', 'file_path', 'submission_type','submission_link','submission_content', 'status', ];

    protected $dates = ['submitted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

            public function materi()
        {
            return $this->belongsTo(Materi::class);
        }

        public function mataPelajaran()
        {
            return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
        }
}
