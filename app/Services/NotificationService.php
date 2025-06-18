namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\BookingStatusUpdated;

class NotificationService
{
    public function notifyBookingStatusUpdate(Booking $booking): void
    {
        $user = $booking->user;
        $user->notify(new BookingStatusUpdated($booking));

        // Create database notification
        Notification::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'type' => 'booking_status',
            'message' => 'Your booking status has been updated to: ' . $booking->status,
            'channel' => 'email',
        ]);
    }

    public function notifyNewBooking(Booking $booking): void
    {
        if ($booking->technician) {
            $technician = $booking->technician->user;
            
            Notification::create([
                'user_id' => $technician->id,
                'booking_id' => $booking->id,
                'type' => 'new_booking',
                'message' => 'You have been assigned a new booking',
                'channel' => 'email',
            ]);

            $technician->notify(new BookingStatusUpdated($booking));
        }
    }

    public function notifyBookingCompletion(Booking $booking): void
    {
        $user = $booking->user;
        
        Notification::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'type' => 'booking_completed',
            'message' => 'Your booking has been completed. Please rate our service.',
            'channel' => 'email',
        ]);

        $user->notify(new BookingStatusUpdated($booking));
    }
} 