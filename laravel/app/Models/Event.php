<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'description',
        'start_date',
        'starttime_am',
        'endtime_am',
        'starttime_pm',
        'endtime_pm',
        // Time-in and timeout attendance periods
        'timein_start_am',
        'timein_end_am',
        'timeout_start_am',
        'timeout_end_am',
        'timein_start_pm',
        'timein_end_pm',
        'timeout_start_pm',
        'timeout_end_pm',
        'status',
        'attendees_type',
        'user_id',
        'semester_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }
    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'event_id');
    }

    // Automatically update event status
    public function updateStatus()
    {
        $startDateTime = Carbon::parse($this->start_date . ' ' . ($this->starttime_am ?: $this->starttime_pm));
        $endDateTime = Carbon::parse($this->start_date . ' ' . ($this->endtime_pm ?: $this->endtime_am));
        $now = Carbon::now();

        // Determine event status
        if ($now->between($startDateTime, $endDateTime)) {
            $this->status = 'ongoing';
        } elseif ($now->greaterThan($endDateTime)) {
            $this->status = 'completed';
            $this->generateFinesForAbsentees();
        } else {
            $this->status = 'upcoming';
        }

        $this->save();
    }

    public function generateFinesForAbsentees()
    {
        // Ensure fines haven't already been generated
        $finesAlreadyGenerated = Fine::where('event_id', $this->id)->exists();
        if ($finesAlreadyGenerated) {
            return;
        }

        $students = Student::all();

        // Generate fines for each attendance period
        $this->generateFinesForPeriod($students, 'timein_start_am', 'timein_end_am', 'timein_am', 25);
        $this->generateFinesForPeriod($students, 'timeout_start_am', 'timeout_end_am', 'timeout_am', 25);
        $this->generateFinesForPeriod($students, 'timein_start_pm', 'timein_end_pm', 'timein_pm', 25);
        $this->generateFinesForPeriod($students, 'timeout_start_pm', 'timeout_end_pm', 'timeout_pm', 25);
    }

    protected function generateFinesForPeriod($students, $startPeriod, $endPeriod, $periodEnumValue, $fineAmount)
    {
        if (is_null($this->$startPeriod) || is_null($this->$endPeriod)) {
            return; // Skip if period isn't defined
        }
    
        $startTime = Carbon::parse($this->start_date . ' ' . $this->$startPeriod);
        $endTime = Carbon::parse($this->start_date . ' ' . $this->$endPeriod);
    
        if (Carbon::now()->greaterThan($endTime)) {
            foreach ($students as $student) {
                // Check if the event is for officers
                if ($this->attendees_type == 'officers') {
                    // If the event is for officers, check if the student is an officer
                    $isOfficer = \DB::table('officers')->where('student_id', $student->id)->exists();
    
                    if (!$isOfficer) {
                        continue; // Skip non-officers if the event is for officers
                    }
                }
    
                // Check if the student attended the event within the specified time period
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('event_id', $this->id)
                    ->whereBetween('created_at', [$startTime, $endTime])
                    ->exists();
    
                if (!$attendance) {
                    // Generate a fine for students who didn't attend
                    Fine::create([
                        'student_id' => $student->id,
                        'event_id' => $this->id,
                        'amount' => $fineAmount,
                        'attendance_period' => $periodEnumValue, // Enum value for period (e.g., timein_am, timeout_pm)
                    ]);
                }
            }
        }
    }
    
}
