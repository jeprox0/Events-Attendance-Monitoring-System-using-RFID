<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'rfid','email','course_year_id','picture','semester_id','user_id'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
    public function fines()
    {
        return $this->hasMany(Fine::class);
    }
    
    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class);
    }

   // In Student.php (Model)
   public function clubs()
   {
       return $this->belongsToMany(Club::class, 'club_student'); // Specify the pivot table
   }
   
   public function groupedContributions()
   {
       // Assuming you have defined a method to get contributions
       return $this->hasMany(Contribution::class)->groupBy('semester_id');
   }
    // In a helper file or your model
function generateAcronym($clubName) {
    // Split the club name by spaces
    $words = explode(' ', $clubName);
    $acronym = '';

    // Iterate through each word and get the first letter
    foreach ($words as $word) {
        $acronym .= strtoupper(substr($word, 0, 1));
    }

    return $acronym;
}

}
