<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingSparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'technician_id', 
        'sparepart_name',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'status',
        'notes',
        'used_at'
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2'
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