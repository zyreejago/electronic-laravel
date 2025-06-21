<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Exports\BookingsExport;
use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportBookings(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        
        // Convert to Carbon instances if they're strings
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }
        
        $filename = 'bookings_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new BookingsExport($startDate, $endDate), $filename);
    }

    public function exportBookingsPdf(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        
        // Convert to Carbon instances if they're strings
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        $bookings = Booking::with(['user', 'service', 'technicians.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $data = [
            'bookings' => $bookings,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalBookings' => $bookings->count(),
            'totalRevenue' => $bookings->sum('total_price'),
            'completedBookings' => $bookings->where('status', 'completed')->count(),
        ];

        $pdf = Pdf::loadView('pdf.bookings-report', $data);
        $filename = 'bookings_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}