<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Fine;
use Illuminate\Console\Command;

class GenerateFines extends Command
{
    protected $signature = 'generate:fines';
    protected $description = 'Generate fines for students who missed events';

    public function handle()
    {
        // Get completed events (those that have ended)
        $events = Event::whereDate('start_date', '<=', now())->get(); 

        foreach ($events as $event) {
            // Check if the event is completed
            $now = \Carbon\Carbon::now();
            $endDateTime = \Carbon\Carbon::parse($event->start_date . ' ' . ($event->endtime_pm ?: $event->endtime_am));

            if ($now->lt($endDateTime)) {
                // Event is still ongoing, skip this event
                continue;
            }

            // Get all students who have not attended the event
            $students = Student::all();
            foreach ($students as $student) {
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('event_id', $event->id)
                    ->first();

                if (!$attendance) {
                    // Create a fine if no attendance record found
                    Fine::firstOrCreate([
                        'student_id' => $student->id,
                        'event_id' => $event->id,
                    ], [
                        'amount' => 25, // Fixed fine amount
                    ]);
                }
            }
        }

        $this->info('Fines generated for all missed events.');
    }
}
