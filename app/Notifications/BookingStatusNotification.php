<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $status;

    public function __construct($booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database', 'whatsapp'];
    }

    public function toWhatsapp($notifiable)
    {
        // Ambil user dari relasi booking, jika tidak ada ambil dari user_id, jika tetap tidak ada fallback ke notifiable
        $user = $this->booking->user
            ?? (isset($this->booking->user_id) ? \App\Models\User::find($this->booking->user_id) : null)
            ?? $notifiable;

        $phoneNumber = $user ? $user->phone_number : null;

        \Log::info('BookingStatusNotification toWhatsapp', [
            'booking_id' => $this->booking->id ?? null,
            'booking_user' => $user,
            'booking_user_id' => $user->id ?? null,
            'phone_number' => $phoneNumber,
            'notifiable_id' => $notifiable->id ?? null,
            'notifiable' => $notifiable
        ]);

        $message = $this->getStatusMessage();
        // Format phone number for WhatsApp
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }
        return [
            'to' => $phoneNumber,
            'message' => $message
        ];
    }

    public function toArray($notifiable)
    {
        $message = $this->getStatusMessage();
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->status,
            'message' => $message,
            'type' => 'booking_status'
        ];
    }

    protected function getStatusMessage()
    {
        $serviceName = $this->booking->service->name;
        $bookingDate = $this->booking->scheduled_at->format('d M Y H:i');
        $customerName = $this->booking->user->name;
        
        switch ($this->status) {
            case 'pending':
                return "🔔 *Update Status Booking*\n\n" .
                       "Halo {$customerName},\n" .
                       "Booking service *{$serviceName}* Anda pada {$bookingDate} telah diterima dan sedang menunggu konfirmasi.\n\n" .
                       "Kami akan segera memproses booking Anda.";
            
            case 'in_progress':
                return "🔧 *Update Status Booking*\n\n" .
                       "Halo {$customerName},\n" .
                       "Service *{$serviceName}* Anda pada {$bookingDate} sedang dalam proses perbaikan oleh teknisi kami.\n\n" .
                       "Kami akan menginformasikan Anda jika ada perkembangan lebih lanjut.";
            
            case 'completed':
                return "✅ *Update Status Booking*\n\n" .
                       "Halo {$customerName},\n" .
                       "Service *{$serviceName}* Anda pada {$bookingDate} telah selesai.\n\n" .
                       "Terima kasih telah menggunakan layanan kami. Kami tunggu kedatangan Anda kembali!";
            
            case 'cancelled':
                return "❌ *Update Status Booking*\n\n" .
                       "Halo {$customerName},\n" .
                       "Mohon maaf, booking service *{$serviceName}* Anda pada {$bookingDate} telah dibatalkan.\n\n" .
                       "Silakan hubungi kami untuk informasi lebih lanjut.";
            
            default:
                return "📱 *Update Status Booking*\n\n" .
                       "Halo {$customerName},\n" .
                       "Status booking service *{$serviceName}* Anda pada {$bookingDate} telah diubah menjadi: *{$this->status}*";
        }
    }
} 