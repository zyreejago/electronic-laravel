<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    public function show(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $booking->load(['user', 'service']);
        
        return view('admin.inspections.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $validated = $request->validate([
            'damage_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'estimated_duration_hours' => 'required|integer|min:1'
        ]);
        
        $booking->update([
            'damage_description' => $validated['damage_description'],
            'estimated_cost' => $validated['estimated_cost'],
            'estimated_duration_hours' => $validated['estimated_duration_hours'],
            'inspection_completed_at' => now(),
            'inspected_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Pemeriksaan awal berhasil disimpan.');
    }
}