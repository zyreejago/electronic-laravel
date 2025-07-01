<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    public function show(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $booking->load(['user', 'service']);
        $technicians = Technician::with('user')->where('is_available', true)->get();
        
        return view('admin.inspections.show', compact('booking', 'technicians'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $validated = $request->validate([
            'damage_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'estimated_duration_hours' => 'required|integer|min:1',
            'technician_id' => 'required|exists:technicians,id'
        ]);
        
        $booking->update([
            'damage_description' => $validated['damage_description'],
            'estimated_cost' => $validated['estimated_cost'],
            'estimated_duration_hours' => $validated['estimated_duration_hours'],
            'technician_id' => $validated['technician_id'],
            'inspection_completed_at' => now(),
            'inspected_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Pemeriksaan awal berhasil disimpan dan teknisi telah ditugaskan.');
    }
}