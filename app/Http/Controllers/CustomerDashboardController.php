<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\AdditionalWorkRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistics
        $totalBookings = $user->bookings()->count();
        $completedBookings = $user->bookings()->where('status', 'completed')->count();
        $pendingBookings = $user->bookings()->where('status', 'pending')->count();
        $inProgressBookings = $user->bookings()->where('status', 'in_progress')->count();
        
        // Recent bookings (last 5)
        $recentBookings = $user->bookings()
            ->with(['service', 'technician.user'])
            ->latest()
            ->take(5)
            ->get();
        
        // Pending additional work requests
        $pendingAdditionalWork = AdditionalWorkRequest::whereHas('booking', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'pending')
            ->with(['booking.service', 'technician.user'])
            ->latest()
            ->get();
        
        // Recent notifications
        $recentNotifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();
        
        // Total spent
        $totalSpent = $user->bookings()
            ->where('status', 'completed')
            ->where('is_paid', true)
            ->sum('total_price');
        
        return view('customer.dashboard', compact(
            'totalBookings',
            'completedBookings', 
            'pendingBookings',
            'inProgressBookings',
            'recentBookings',
            'pendingAdditionalWork',
            'recentNotifications',
            'totalSpent'
        ));
    }
}