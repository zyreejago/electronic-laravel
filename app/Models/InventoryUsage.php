<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'technician_id',
        'booking_id',
        'quantity_used',
        'used_at',
        'notes'
    ];

    protected $casts = [
        'used_at' => 'datetime'
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}