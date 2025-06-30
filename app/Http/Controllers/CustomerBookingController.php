<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->bookings()
            ->with(['service', 'technician.user', 'rating'])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('id', 'like', "%{$request->search}%")
                        ->orWhereHas('service', function($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%");
                        });
                });
            });

        $bookings = $query->latest()->paginate(10);
        
        return view('customer.bookings.index', compact('bookings'));
    }
    
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load([
            'service',
            'technician.user', 
            'serviceComponents',
            'inventoryUsages.inventoryItem',
            'inventoryUsages.technician.user',
            'additionalWorkRequests.technician.user',
            'progressNotes',
            'rating'
        ]);
        
        // Hapus baris ini:
        // \Log::info('Booking ID: ' . $booking->id);
        // \Log::info('Inventory Usages Count: ' . $booking->inventoryUsages->count());
        // \Log::info('Inventory Cost: ' . $booking->inventory_cost);
        
        return view('customer.bookings.show', compact('booking'));
    }
    
    public function history(Request $request)
    {
        $query = Auth::user()->bookings()
            ->with(['service', 'technician.user', 'rating'])
            ->where('status', 'completed')
            ->when($request->year, function($q) use ($request) {
                return $q->whereYear('completed_at', $request->year);
            })
            ->when($request->month, function($q) use ($request) {
                return $q->whereMonth('completed_at', $request->month);
            });

        $bookings = $query->latest('completed_at')->paginate(15);
        
        // Years for filter
        $years = Auth::user()->bookings()
            ->where('status', 'completed')
            ->selectRaw('YEAR(completed_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('customer.bookings.history', compact('bookings', 'years'));
    }
    
    public function downloadHandover(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'Handover receipt hanya tersedia untuk booking yang sudah selesai.');
        }
        
        $pdf = Pdf::loadView('pdf.customer-handover-receipt', compact('booking'));
        return $pdf->download('handover-receipt-' . $booking->id . '.pdf');
    }
    
    public function exportHistory(Request $request)
    {
        $bookings = Auth::user()->bookings()
            ->with(['service', 'technician.user'])
            ->where('status', 'completed')
            ->when($request->year, function($q) use ($request) {
                return $q->whereYear('completed_at', $request->year);
            })
            ->latest('completed_at')
            ->get();
        
        $pdf = Pdf::loadView('pdf.customer-service-history', compact('bookings'));
        return $pdf->download('service-history-' . now()->format('Y-m-d') . '.pdf');
    }
}