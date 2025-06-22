<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingProgressNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'technician_id',
        'type',
        'title',
        'description',
        'attachments',
        'visibility',
        'progress_percentage',
        'noted_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'noted_at' => 'datetime'
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