<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceComponentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\LoyaltyPointController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password Management Routes
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public Service Routes (accessible to all authenticated users)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
//     Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
// });

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    // User booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/rate', [BookingController::class, 'rate'])->name('bookings.rate');
    Route::post('/bookings/{booking}/rate', [BookingController::class, 'submitRate'])->name('bookings.submitRate');
    Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    
    Route::get('/loyalty-points', [LoyaltyPointController::class, 'index'])->name('loyalty-points.index');
    Route::post('/loyalty-points/use/{booking}', [LoyaltyPointController::class, 'usePoints'])->name('loyalty-points.use');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');

    Route::post('/bookings/{booking}/pay', [BookingController::class, 'pay'])->name('bookings.pay');
});

// Technician Routes
Route::middleware(['auth', 'role:technician'])->group(function () {
    Route::get('/technician/bookings', [BookingController::class, 'technicianIndex'])->name('technician.bookings.index');
    Route::get('/technician/bookings/{booking}', [BookingController::class, 'technicianShow'])->name('technician.bookings.show');
    Route::put('/technician/bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('technician.bookings.update-status');
    Route::post('/technician/bookings/{booking}/components', [BookingController::class, 'addComponent'])->name('technician.bookings.add-component');
    Route::post('/technician/bookings/{booking}/repair-report', [BookingController::class, 'submitRepairReport'])->name('technician.bookings.repair-report');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Service management - admin only
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::resource('services', ServiceController::class)->except(['index', 'show']);
    Route::resource('service-components', ServiceComponentController::class);
    
    // Direct admin routes
    Route::resource('technicians', TechnicianController::class);
    
    // Prefixed admin routes
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('admins', AdminController::class);
        Route::resource('customers', CustomerController::class);
        Route::get('customers/{customer}/change-password', [CustomerController::class, 'changePasswordForm'])->name('customers.change-password-form');
        Route::put('customers/{customer}/change-password', [CustomerController::class, 'changePassword'])->name('customers.change-password');
        Route::put('customers/{customer}/reset-password', [CustomerController::class, 'resetPassword'])->name('customers.reset-password');
        
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
        Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'adminShow'])->name('bookings.show');
        Route::post('/bookings/{booking}/verify-payment', [BookingController::class, 'verifyPayment'])->name('bookings.verify-payment');
        Route::put('/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('bookings.update');
        Route::post('/bookings/{booking}/assign', [BookingController::class, 'assignTechnician'])->name('bookings.assign');
        // Di dalam group admin
        Route::get('inspections/{booking}', [InspectionController::class, 'show'])->name('inspections.show');
        Route::put('inspections/{booking}', [InspectionController::class, 'update'])->name('inspections.update');
});
});

// Test WhatsApp Notification
Route::get('/test-whatsapp/{phone?}', function ($phone = null) {
    if ($phone) {
        // Buat user dummy untuk testing (simpan ke database)
        $user = \App\Models\User::firstOrCreate(
            ['phone_number' => $phone],
            [
                'name' => 'Test User',
                'email' => $phone . '@test.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ]
        );

        // Buat booking dummy untuk testing
        $booking = new \App\Models\Booking();
        $booking->service = new \App\Models\Service();
        $booking->service->name = 'Test Service';
        $booking->scheduled_at = now();
        $booking->user = $user;

        $user->notify(new \App\Notifications\BookingStatusNotification(
            $booking,
            'pending'
        ));
        return 'WhatsApp notification sent to ' . $phone . '! Check your phone.';
    }
    return 'Please provide a phone number: /test-whatsapp/08123456789';
});

require __DIR__.'/pdf.php';