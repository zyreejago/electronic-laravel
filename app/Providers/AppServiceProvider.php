<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\WhatsappChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Illuminate\Support\Facades\Notification::resolved(function ($service) {
            $service->extend('whatsapp', function ($app) {
                return new \App\Notifications\Channels\WhatsappChannel();
            });
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the role middleware
        Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
    }
}
