<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot_id');
    }

    public function getLabelAttribute(): string
    {
        return now()->parse($this->start_time)->format('H:i') . ' - ' . now()->parse($this->end_time)->format('H:i');
    }
}
