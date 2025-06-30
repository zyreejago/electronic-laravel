<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true; // Semua user yang sudah login bisa melihat daftar booking
    }

    public function create(User $user)
    {
        return $user->role === 'user'; // Hanya user yang bisa membuat booking
    }

    public function store(User $user)
    {
        return $user->role === 'user'; // Hanya user yang bisa menyimpan booking
    }

    public function view(User $user, Booking $booking)
    {
        // User bisa melihat booking mereka sendiri
        if ($user->id === $booking->user_id) {
            return true;
        }

        // Admin bisa melihat semua booking
        if ($user->role === 'admin') {
            return true;
        }

        // Teknisi bisa melihat booking yang ditugaskan ke mereka
        if ($user->role === 'technician') {
            // Cek apakah teknisi ini pernah ditugaskan ke booking ini
            return $booking->technician_id === $user->technician->id || 
                   $booking->status === 'completed'; // Teknisi bisa lihat booking completed
        }

        return false;
    }

    public function viewAsTechnician(User $user, Booking $booking)
    {
        return $user->role === 'technician';
    }

    public function updateStatus(User $user, Booking $booking)
    {
        return $user->role === 'technician';
    }

    public function addComponent(User $user, Booking $booking)
    {
        return $user->role === 'technician' && $user->technician->id === $booking->technician_id;
    }

    public function rate(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id && $booking->status === 'completed' && !$booking->rating;
    }

    public function update(User $user, Booking $booking)
    {
        return $user->role === 'admin';
    }

    public function viewInvoice(User $user, Booking $booking)
    {
        // User bisa melihat invoice booking mereka sendiri yang sudah dibayar
        if ($user->id === $booking->user_id && $booking->is_paid) {
            return true;
        }
    
        // Admin bisa melihat semua invoice
        if ($user->role === 'admin') {
            return true;
        }
    
        return false;
    }
}