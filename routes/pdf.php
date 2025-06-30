<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ExportController;

// PDF Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/bookings/{booking}/handover-receipt', [PDFController::class, 'generateHandoverReceipt'])
        ->name('bookings.handover-receipt');
    // Hapus atau comment line ini:
    // Route::get('/bookings/{booking}/invoice', [PDFController::class, 'generateInvoice'])
    //     ->name('bookings.invoice');
    Route::get('/reports/monthly-pdf', [PDFController::class, 'generateMonthlyReport'])
        ->name('reports.monthly-pdf');
    
    // Inspection Routes
    Route::get('/admin/bookings/{booking}/inspection', [InspectionController::class, 'show'])
        ->name('admin.inspections.show');
    Route::put('/admin/bookings/{booking}/inspection', [InspectionController::class, 'update'])
        ->name('admin.inspections.update');
    
    // Export Routes dengan prefix admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/export/bookings', [ExportController::class, 'exportBookings'])
            ->name('export.bookings');
        Route::get('/export/bookings-pdf', [ExportController::class, 'exportBookingsPdf'])
            ->name('export.bookings.pdf');
    });
});