<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappChannel
{
    public function send($notifiable, Notification $notification)
    {
        \Log::info('WhatsappChannel send called', [
            'notifiable' => $notifiable,
            'notification' => $notification
        ]);
        if (method_exists($notification, 'toWhatsapp')) {
            try {
                $message = $notification->toWhatsapp($notifiable);
                
                // Send message using WhatsApp Web API
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post('http://localhost:3000/send-message', [
                    'to' => $message['to'],
                    'message' => $message['message']
                ]);
                
                // Log the response for debugging
                Log::info('WhatsApp Web API Response:', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'message' => $message
                ]);
                
                if (!$response->successful()) {
                    Log::error('WhatsApp Web API Error:', [
                        'status' => $response->status(),
                        'body' => $response->json(),
                        'message' => $message
                    ]);
                }
                
                return $response->json();
            } catch (\Exception $e) {
                Log::error('WhatsApp Notification Error:', [
                    'error' => $e->getMessage(),
                    'message' => $message ?? null
                ]);
                
                return false;
            }
        }
    }
} 