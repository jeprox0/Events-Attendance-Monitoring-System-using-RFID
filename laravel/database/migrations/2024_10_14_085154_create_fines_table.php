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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('event_id');
    
            // Adding attendance_period column to track fines for each period
            $table->enum('attendance_period', ['timein_am', 'timeout_am', 'timein_pm', 'timeout_pm']);
            
            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
