<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['club_name'];

   public function students()
    {
        return $this->belongsToMany(Student::class, 'club_student'); // Specify the pivot table
    }

}
