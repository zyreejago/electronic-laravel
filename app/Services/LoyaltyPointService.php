<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointTransaction;
use Illuminate\Support\Facades\DB;

class LoyaltyPointService
{
    public function calculatePoints(Booking $booking): int
    {
        // 1 point per Rp10.000
        return (int) ($booking->total_price / 10000);
    }

    public function addPoints(Booking $booking): void
    {
        if ($booking->status !== 'completed') {
            return;
        }

        $points = $this->calculatePoints($booking);

        DB::transaction(function () use ($booking, $points) {
            $loyaltyPoints = LoyaltyPoint::firstOrCreate(
                ['user_id' => $booking->user_id],
                ['points' => 0, 'points_value' => 0]
            );

            $loyaltyPoints->increment('points', $points);
            $loyaltyPoints->increment('points_value', $points * 100); // Rp100 per point

            LoyaltyPointTransaction::create([
                'loyalty_point_id' => $loyaltyPoints->id,
                'booking_id' => $booking->id,
                'points' => $points,
                'type' => 'earned',
                'description' => 'Points earned from completed booking',
            ]);
        });
    }

    public function usePoints(LoyaltyPoint $loyaltyPoints, int $points, Booking $booking): bool
    {
        if ($loyaltyPoints->points < $points) {
            return false;
        }

        DB::transaction(function () use ($loyaltyPoints, $points, $booking) {
            $loyaltyPoints->decrement('points', $points);
            $loyaltyPoints->decrement('points_value', $points * 100);

            LoyaltyPointTransaction::create([
                'loyalty_point_id' => $loyaltyPoints->id,
                'booking_id' => $booking->id,
                'points' => -$points,
                'type' => 'used',
                'description' => 'Points used for booking discount',
            ]);
        });

        return true;
    }
} 