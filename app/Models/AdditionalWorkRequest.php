<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalWorkRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'technician_id',
        'title',
        'description', 
        'reason',
        'estimated_cost',
        'estimated_duration_hours',
        'priority',
        'status',
        'customer_response',
        'admin_notes',
        'requested_at',
        'responded_at',
        'completed_at'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'requested_at' => 'datetime',
        'responded_at' => 'datetime', 
        'completed_at' => 'datetime'
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