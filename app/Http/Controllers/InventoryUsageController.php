<?php

namespace App\Http\Controllers;

use App\Models\InventoryUsage;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryUsageController extends Controller
{
    public function approve(InventoryUsage $inventoryUsage)
    {
        // Pastikan user adalah pemilik booking
        if (Auth::id() !== $inventoryUsage->booking->user_id) {
            abort(403, 'Unauthorized');
        }

        // Update status menjadi approved
        $inventoryUsage->update([
            'status' => 'approved'
        ]);

        // Update total cost booking
        $this->updateBookingInventoryCost($inventoryUsage->booking);

        return redirect()->back()->with('success', 'Penggunaan spare part telah disetujui.');
    }

    public function reject(Request $request, InventoryUsage $inventoryUsage)
    {
        // Pastikan user adalah pemilik booking
        if (Auth::id() !== $inventoryUsage->booking->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        // Update status menjadi rejected
        $inventoryUsage->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        // Update total cost booking
        $this->updateBookingInventoryCost($inventoryUsage->booking);

        return redirect()->back()->with('success', 'Penggunaan spare part telah ditolak.');
    }

    private function updateBookingInventoryCost(Booking $booking)
    {
        // Hitung ulang inventory cost berdasarkan yang approved saja
        $approvedUsages = $booking->inventoryUsages()->where('status', 'approved')->get();
        
        $totalInventoryCost = $approvedUsages->sum(function ($usage) {
            return $usage->quantity_used * $usage->inventoryItem->unit_price;
        });

        $booking->update([
            'inventory_cost' => $totalInventoryCost
        ]);

        // Update total price jika inspection sudah selesai
        if ($booking->inspection_completed_at && $booking->estimated_cost) {
            $serviceComponentsCost = $booking->serviceComponents->sum(function($component) {
                return $component->pivot->quantity * $component->pivot->price_at_time;
            });
            
            $deliveryFee = ($booking->service_type === 'pickup' || $booking->service_type === 'onsite') ? 50000 : 0;
            $emergencyFee = $booking->is_emergency ? 100000 : 0;
            $loyaltyDiscount = $booking->loyalty_points_used ? $booking->loyalty_points_used * 100 : 0;
            
            $totalPrice = $booking->estimated_cost + $totalInventoryCost + $serviceComponentsCost + $deliveryFee + $emergencyFee - $loyaltyDiscount;
            
            $booking->update([
                'total_price' => $totalPrice
            ]);
        }
    }
}