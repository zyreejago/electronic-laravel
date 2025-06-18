<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_available' => 'boolean',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_service_components')
            ->withPivot('quantity', 'price_at_time')
            ->withTimestamps();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_component_pivot')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
