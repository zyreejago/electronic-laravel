<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingTechnician extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'technician_id',
        'role'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}