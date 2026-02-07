<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'club_id',
        'position_name',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}


