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
        'completed_at', // Add this line
        'payment_proof',
        'ewallet_type',
        'is_paid',
        'loyalty_points_used',
        'emergency_fee',
        'is_emergency',
        'repair_report',
        // Field pemeriksaan awal
        'damage_description',
        'estimated_cost',
        'estimated_duration_hours',
        'inspection_completed_at',
        'inspected_by',
        // Field dashboard teknisi baru
        'overall_progress_percentage',
        'work_started_at',
        'work_paused_at',
        'current_status_notes',
        'estimated_work_hours',
        'actual_work_hours',
        'last_customer_update',
        'requires_customer_approval',
        'damage_category',
'item_condition', 
'accessories_included',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime', // Add this line
        'inspection_completed_at' => 'datetime',
        'work_started_at' => 'datetime',
        'work_paused_at' => 'datetime',
        'last_customer_update' => 'datetime'
    ];

    // Relasi baru
    public function spareparts()
    {
        return $this->hasMany(BookingSparepart::class);
    }

    public function additionalWorkRequests()
    {
        return $this->hasMany(AdditionalWorkRequest::class);
    }

    public function progressNotes()
    {
        return $this->hasMany(BookingProgressNote::class);
    }

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

    public function inventoryUsages()
    {
        return $this->hasMany(InventoryUsage::class);
    }

    // Tambahkan method baru untuk menghitung inventory cost
    public function getInventoryCostAttribute()
    {
        return $this->inventoryUsages->sum(function ($usage) {
            // Bisa error jika inventoryItem null
            if (!$usage->inventoryItem) {
                \Log::warning('InventoryItem not found for usage ID: ' . $usage->id);
                return 0;
            }
            return $usage->quantity_used * $usage->inventoryItem->unit_price;
        });
    }

    // Method untuk menghitung total price lengkap
    public function calculateTotalPrice()
    {
        $basePrice = $this->service->price;
        $componentsPrice = $this->serviceComponents->sum(function ($component) {
            return $component->pivot->quantity * $component->pivot->price_at_time;
        });
        $inventoryPrice = $this->inventory_cost;
        $deliveryFee = in_array($this->service_type, ['pickup', 'onsite']) ? 50000 : 0;
        $emergencyFee = $this->is_emergency ? 100000 : 0;
        $loyaltyDiscount = $this->loyalty_points_used ? ($this->loyalty_points_used * 100) : 0;
        
        return $basePrice + $componentsPrice + $inventoryPrice + $deliveryFee + $emergencyFee - $loyaltyDiscount;
    }
}

