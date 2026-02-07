<?php

namespace App\Listeners;

use App\Events\EventEnded;
use App\Models\Attendance;
use App\Models\Fine;
use App\Models\Student;

class GenerateFinesListener
{
    /**
     * Handle the event.
     */
    public function handle(EventEnded $event)
    {
        $eventId = $event->event->id;

        // Get all students
        $students = Student::all();

        // For each student, check if they missed the event
        foreach ($students as $student) {
            $attendance = Attendance::where('student_id', $student->id)
                                    ->where('event_id', $eventId)
                                    ->first();

            if (!$attendance) {
                // If no attendance record, generate a fine
                Fine::firstOrCreate([
                    'student_id' => $student->id,
                    'event_id' => $eventId,
                ], [
                    'amount' => 25, // Set fine amount
                ]);
            }
        }
    }
}
