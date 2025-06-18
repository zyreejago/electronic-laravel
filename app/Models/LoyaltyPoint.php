<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'points',
        'points_value',
    ];

    protected $casts = [
        'points' => 'integer',
        'points_value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyPointTransaction::class);
    }
}

class LoyaltyPointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_point_id',
        'booking_id',
        'points',
        'type',
        'description',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function loyaltyPoint()
    {
        return $this->belongsTo(LoyaltyPoint::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
