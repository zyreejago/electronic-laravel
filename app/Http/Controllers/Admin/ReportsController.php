<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // Get booking statistics
        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        // Get monthly bookings data for the chart
        $monthlyBookings = Booking::select(
            DB::raw('DATE_FORMAT(created_at, "%M %Y") as month'),
            DB::raw('count(*) as count')
        )
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        // Get top services
        $topServices = Service::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Get technician performance stats
        $technicianStats = Technician::with('user')
            ->withCount(['bookings as completed_jobs' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withAvg('ratings', 'rating')
            ->withSum(['bookings as total_revenue' => function ($query) {
                $query->where('status', 'completed');
            }], 'total_price')
            ->get()
            ->map(function ($technician) {
                $totalJobs = $technician->bookings()->where('status', 'completed')->count();
                $onTimeJobs = $technician->bookings()
                    ->where('status', 'completed')
                    ->where('completed_at', '<=', DB::raw('scheduled_at'))
                    ->count();
                
                return [
                    'name' => $technician->user->name,
                    'completed_jobs' => $technician->completed_jobs,
                    'average_rating' => $technician->ratings_avg_rating ?? 0,
                    'on_time_percentage' => $totalJobs > 0 ? ($onTimeJobs / $totalJobs) * 100 : 0,
                    'total_revenue' => $technician->total_revenue ?? 0
                ];
            });

        return view('admin.reports', compact(
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'totalRevenue',
            'monthlyBookings',
            'topServices',
            'technicianStats'
        ));
    }
} 