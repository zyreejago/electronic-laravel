<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointTransaction;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoyaltyPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $currentPoints = $user->loyaltyPoints()->sum('points');
        $pointsToNextReward = max(0, 100 - ($currentPoints % 100)); // Assuming reward every 100 points
        $transactions = $user->loyaltyPoints()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('loyalty-points.index', compact('currentPoints', 'pointsToNextReward', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function usePoints(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        $validated = $request->validate([
            'points' => 'required|integer|min:0|max:' . auth()->user()->loyaltyPoints->sum('points'),
        ]);

        if ($validated['points'] === 0) {
            return redirect()->back()
                ->with('error', 'Please enter the number of points you want to use.');
        }

        $loyaltyPoint = auth()->user()->loyaltyPoints()->first();
        $pointsValue = $validated['points'] * 100; // 1 point = Rp100

        if ($pointsValue > $booking->total_price) {
            return redirect()->back()
                ->with('error', 'Points value cannot exceed the total price.');
        }

        DB::transaction(function () use ($booking, $loyaltyPoint, $validated) {
            $booking->update([
                'loyalty_points_used' => $validated['points'],
                'total_price' => $booking->total_price - ($validated['points'] * 100)
            ]);

            $loyaltyPoint->decrement('points', $validated['points']);
            $loyaltyPoint->decrement('points_value', $validated['points'] * 100);

            LoyaltyPointTransaction::create([
                'loyalty_point_id' => $loyaltyPoint->id,
                'booking_id' => $booking->id,
                'points' => -$validated['points'],
                'type' => 'used',
                'description' => 'Points used for booking discount',
            ]);
        });

        return redirect()->back()
            ->with('success', 'Loyalty points used successfully.');
    }
}
