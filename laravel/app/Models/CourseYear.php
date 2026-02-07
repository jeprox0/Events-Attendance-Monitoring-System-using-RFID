<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'year_level',
    ];
    protected $table = 'courses_years';
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
