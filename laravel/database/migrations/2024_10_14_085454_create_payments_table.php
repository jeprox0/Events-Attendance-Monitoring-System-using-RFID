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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // The student making the payment
            $table->decimal('amount_paid', 8, 2); // Total amount paid by the student
            $table->string('or_number'); // Official receipt number
            $table->unsignedBigInteger('semester_id'); // Reference to the semester
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP')); // When the payment is made
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
        
            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade'); // Foreign key to semesters
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
