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
    Schema::create('students', function (Blueprint $table) {
        $table->id(); // Creates an unsigned big integer as the primary key
        $table->string('first_name');
        $table->string('last_name');
        
        // Assuming course_year_id and club_id reference other tables
        $table->unsignedBigInteger('course_year_id')->nullable();
   
        
        $table->string('email')->unique();
        $table->string('picture')->nullable();
        $table->string('rfid');
        $table->string('semester_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();

      
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
