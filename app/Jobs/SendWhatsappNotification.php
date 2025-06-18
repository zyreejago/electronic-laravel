<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phoneNumber;
    public $message;

    /**
     * Create a new job instance.
     */
    public function __construct($phoneNumber, $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('SendWhatsappNotification handle', [
            'original_phone' => $this->phoneNumber,
            'message' => $this->message,
        ]);
        $phoneNumber = preg_replace('/[^0-9]/', '', $this->phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://localhost:3000/send-message', [
            'phone' => $phoneNumber,
            'message' => $this->message
        ]);

        Log::info('SendWhatsappNotification response', [
            'to' => $phoneNumber,
            'status' => $response->status(),
            'body' => $response->json()
        ]);
    }
}
