<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingSparepart;
use App\Models\AdditionalWorkRequest;
use App\Models\BookingProgressNote;

class TechnicianBookingController extends Controller
{
    public function updateProgress(Request $request, Booking $booking)
    {
        $request->validate([
            'overall_progress_percentage' => 'required|integer|min:0|max:100',
            'actual_work_hours' => 'nullable|numeric|min:0',
            'current_status_notes' => 'nullable|string|max:1000',
        ]);

        $booking->update([
            'overall_progress_percentage' => $request->overall_progress_percentage,
            'actual_work_hours' => $request->actual_work_hours,
            'current_status_notes' => $request->current_status_notes,
            'last_customer_update' => now(),
        ]);

        return redirect()->back()->with('success', 'Progress updated successfully!');
    }

    public function addSparepart(Request $request, Booking $booking)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        BookingSparepart::create([
            'booking_id' => $booking->id,
            'part_name' => $request->part_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
        ]);

        return redirect()->back()->with('success', 'Spare part added successfully!');
    }

    public function removeSparepart(Booking $booking, BookingSparepart $sparepart)
    {
        $sparepart->delete();
        return redirect()->back()->with('success', 'Spare part removed successfully!');
    }

    public function requestAdditionalWork(Request $request, Booking $booking)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'estimated_cost' => 'required|numeric|min:0',
        ]);

        AdditionalWorkRequest::create([
            'booking_id' => $booking->id,
            'description' => $request->description,
            'estimated_cost' => $request->estimated_cost,
            'status' => 'pending',
            'requested_by_user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Additional work request submitted!');
    }

    public function addProgressNote(Request $request, Booking $booking)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        BookingProgressNote::create([
            'booking_id' => $booking->id,
            'note' => $request->note,
            'created_by_user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Progress note added successfully!');
    }
}