<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('semester_id');
            $table->enum('attendees_type', ['all', 'officers']);
            $table->date('start_date');
            $table->enum('status', ['upcoming', 'ongoing', 'completed']);
            $table->time('starttime_am')->nullable();
            $table->time('endtime_am')->nullable();
            $table->time('timein_start_am')->nullable();
            $table->time('timein_end_am')->nullable();
            $table->time('timeout_start_am')->nullable();
            $table->time('timeout_end_am')->nullable();
            $table->time('starttime_pm')->nullable();
            $table->time('endtime_pm')->nullable();
            $table->time('timein_start_pm')->nullable();
            $table->time('timein_end_pm')->nullable();
            $table->time('timeout_start_pm')->nullable();
            $table->time('timeout_end_pm')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
