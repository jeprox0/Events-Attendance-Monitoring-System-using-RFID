<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'amount',
        'student_id',
        'event_id',
        'attendance_period',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Define the inverse relationship to Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    
}
