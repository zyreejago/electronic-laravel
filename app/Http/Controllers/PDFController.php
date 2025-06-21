<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PDFController extends Controller
{
    public function generateHandoverReceipt(Booking $booking)
    {
        $booking->load(['user', 'service', 'technicians.user', 'serviceComponents']);
        
        $pdf = Pdf::loadView('pdf.handover-receipt', compact('booking'));
        
        return $pdf->download('serah-terima-' . $booking->id . '.pdf');
    }

    public function generateInvoice(Booking $booking)
    {
        $booking->load(['user', 'service', 'technicians.user', 'serviceComponents']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('booking'));
        
        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }

    public function generateMonthlyReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();
        
        $bookings = Booking::with(['user', 'service', 'technicians.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
            
        $totalRevenue = $bookings->where('status', 'completed')->sum('total_price');
        $totalBookings = $bookings->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        
        $data = [
            'bookings' => $bookings,
            'month' => $month,
            'totalRevenue' => $totalRevenue,
            'totalBookings' => $totalBookings,
            'completedBookings' => $completedBookings,
            'pendingBookings' => $pendingBookings
        ];
        
        $pdf = Pdf::loadView('pdf.monthly-report', $data);
        
        return $pdf->download('laporan-bulanan-' . $month . '.pdf');
    }
}