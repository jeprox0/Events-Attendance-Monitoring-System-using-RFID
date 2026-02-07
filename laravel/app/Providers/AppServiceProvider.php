<?php

namespace App\Providers;

use App\Events\EventEnded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Listeners\GenerateFinesListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register event and listener here
        Event::listen(
            EventEnded::class,
            [GenerateFinesListener::class, 'handle']
        );
        DB::listen(function ($query) {
            Log::info($query->sql);
        });
    }
}
