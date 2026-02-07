<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_rfid', 
        'event_id',
        'attendance_period',
      
       
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Define relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}

