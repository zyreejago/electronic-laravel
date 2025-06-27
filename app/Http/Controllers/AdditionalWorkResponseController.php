<?php

namespace App\Http\Controllers;

use App\Models\AdditionalWorkRequest;
use App\Jobs\SendWhatsappNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditionalWorkResponseController extends Controller
{
    public function index()
    {
        $pendingRequests = AdditionalWorkRequest::whereHas('booking', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->with(['booking.service', 'technician.user'])
            ->latest()
            ->paginate(10);
        
        $respondedRequests = AdditionalWorkRequest::whereHas('booking', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereIn('status', ['approved', 'rejected'])
            ->with(['booking.service', 'technician.user'])
            ->latest('responded_at')
            ->paginate(10);
        
        return view('customer.additional-work.index', compact('pendingRequests', 'respondedRequests'));
    }
    
    public function show(AdditionalWorkRequest $additionalWorkRequest)
    {
        // Check if user owns the booking
        if ($additionalWorkRequest->booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        $additionalWorkRequest->load(['booking.service', 'technician.user']);
        
        return view('customer.additional-work.show', compact('additionalWorkRequest'));
    }
    
    public function approve(Request $request, AdditionalWorkRequest $additionalWorkRequest)
    {
        // Check if user owns the booking
        if ($additionalWorkRequest->booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        if ($additionalWorkRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request sudah direspon sebelumnya.');
        }
        
        $additionalWorkRequest->update([
            'status' => 'approved',
            'customer_response' => 'approved',
            'responded_at' => now()
        ]);
        
        // Update booking total price
        $booking = $additionalWorkRequest->booking;
        $booking->increment('total_price', $additionalWorkRequest->estimated_cost);
        
        // Send WhatsApp notification to technician
        if ($additionalWorkRequest->technician->user->phone_number) {
            $message = "✅ *Pekerjaan Tambahan Disetujui*\n\nHalo {$additionalWorkRequest->technician->user->name},\nCustomer telah menyetujui pekerjaan tambahan untuk booking #{$booking->id}.\n\nJudul: {$additionalWorkRequest->title}\nBiaya: Rp " . number_format($additionalWorkRequest->estimated_cost, 0, ',', '.') . "\n\nSilakan lanjutkan pekerjaan.";
            
            (new SendWhatsappNotification($additionalWorkRequest->technician->user->phone_number, $message))->handle();
        }
        
        return redirect()->route('customer.additional-work.index')
            ->with('success', 'Pekerjaan tambahan berhasil disetujui.');
    }
    
    public function reject(Request $request, AdditionalWorkRequest $additionalWorkRequest)
    {
        // Check if user owns the booking
        if ($additionalWorkRequest->booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        if ($additionalWorkRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request sudah direspon sebelumnya.');
        }
        
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $additionalWorkRequest->update([
            'status' => 'rejected',
            'customer_response' => 'rejected',
            'admin_notes' => $request->rejection_reason,
            'responded_at' => now()
        ]);
        
        // Send WhatsApp notification to technician
        if ($additionalWorkRequest->technician->user->phone_number) {
            $message = "❌ *Pekerjaan Tambahan Ditolak*\n\nHalo {$additionalWorkRequest->technician->user->name},\nCustomer telah menolak pekerjaan tambahan untuk booking #{$additionalWorkRequest->booking->id}.\n\nJudul: {$additionalWorkRequest->title}\nAlasan: {$request->rejection_reason}";
            
            (new SendWhatsappNotification($additionalWorkRequest->technician->user->phone_number, $message))->handle();
        }
        
        return redirect()->route('customer.additional-work.index')
            ->with('success', 'Pekerjaan tambahan berhasil ditolak.');
    }
}