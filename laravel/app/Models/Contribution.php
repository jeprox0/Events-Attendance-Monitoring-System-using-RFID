<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
        'user_id',
        'event_id',
        'semester_id',
        'user_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
