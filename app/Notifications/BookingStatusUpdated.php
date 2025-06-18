namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Status Updated')
            ->line('Your booking status has been updated to: ' . $this->booking->status)
            ->line('Booking ID: ' . $this->booking->id)
            ->line('Service: ' . $this->booking->service->name)
            ->action('View Booking', route('bookings.show', $this->booking))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
            'message' => 'Your booking status has been updated to: ' . $this->booking->status,
        ];
    }
} 