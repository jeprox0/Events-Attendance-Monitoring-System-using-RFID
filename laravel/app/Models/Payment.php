<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $casts = [
        'payment_date' => 'datetime',
    ];
    
    protected $fillable = [
        'student_id',
        'amount_paid',
        'or_number',
        'payment_date',
        'semester_id',
        'user_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
