<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'technician_id',
        'description',
        'service_type',
        'address',
        'scheduled_at',
        'status',
        'total_price',
        'payment_proof',
        'ewallet_type',
        'is_paid',
        'loyalty_points_used',
        'emergency_fee',
        'is_emergency',
        'repair_report',
        // Tambahkan field pemeriksaan awal
        'damage_description',
        'estimated_cost',
        'estimated_duration_hours',
        'inspection_completed_at',
        'inspected_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'inspection_completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    // Add this new relationship
    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'booking_technicians')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function statusUpdater()
    {
        return $this->belongsTo(User::class, 'status_updated_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function serviceComponents()
    {
        return $this->belongsToMany(ServiceComponent::class, 'booking_service_components')
            ->withPivot('quantity', 'price_at_time')
            ->withTimestamps();
    }
}
