<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Field untuk tracking progress - menggunakan 'updated_at' sebagai referensi yang pasti ada
            $table->integer('overall_progress_percentage')->default(0)->after('updated_at');
            $table->timestamp('work_started_at')->nullable()->after('overall_progress_percentage');
            $table->timestamp('work_paused_at')->nullable()->after('work_started_at');
            $table->text('current_status_notes')->nullable()->after('work_paused_at');
            
            // Field untuk estimasi waktu
            $table->integer('estimated_work_hours')->nullable()->after('current_status_notes');
            $table->integer('actual_work_hours')->nullable()->after('estimated_work_hours');
            
            // Field untuk customer communication
            $table->timestamp('last_customer_update')->nullable()->after('actual_work_hours');
            $table->boolean('requires_customer_approval')->default(false)->after('last_customer_update');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'overall_progress_percentage',
                'work_started_at',
                'work_paused_at', 
                'current_status_notes',
                'estimated_work_hours',
                'actual_work_hours',
                'last_customer_update',
                'requires_customer_approval'
            ]);
        });
    }
};