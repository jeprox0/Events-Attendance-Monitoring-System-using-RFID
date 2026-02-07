<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\GenerateFines;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('generate:fines', function () {
    $this->call(GenerateFines::class);
})->describe('Generate fines for students who missed events');

Artisan::command('schedule:run', function () {
    $schedule = app(Schedule::class);
    $schedule->command('generate:fines')->daily();
});
