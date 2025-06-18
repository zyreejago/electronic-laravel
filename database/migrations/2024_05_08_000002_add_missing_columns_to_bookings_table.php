<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'description')) {
                $table->text('description')->after('technician_id');
            }
            if (!Schema::hasColumn('bookings', 'service_type')) {
                $table->enum('service_type', ['pickup', 'dropoff', 'onsite'])->after('description');
            }
            if (!Schema::hasColumn('bookings', 'address')) {
                $table->text('address')->nullable()->after('service_type');
            }
            if (!Schema::hasColumn('bookings', 'scheduled_at')) {
                $table->dateTime('scheduled_at')->after('address');
            }
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('scheduled_at');
            }
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'completed_at')) {
                $table->dateTime('completed_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'loyalty_points_used')) {
                $table->integer('loyalty_points_used')->nullable()->after('total_price');
            }
            if (!Schema::hasColumn('bookings', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('loyalty_points_used');
            }
            if (!Schema::hasColumn('bookings', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('is_paid');
            }
            if (!Schema::hasColumn('bookings', 'ewallet_type')) {
                $table->enum('ewallet_type', ['ovo', 'dana', 'gopay', 'spay'])->nullable()->after('payment_proof');
            }
            if (!Schema::hasColumn('bookings', 'repair_report')) {
                $table->text('repair_report')->nullable()->after('ewallet_type');
            }
            if (!Schema::hasColumn('bookings', 'is_emergency')) {
                $table->boolean('is_emergency')->default(false)->after('repair_report');
            }
            if (!Schema::hasColumn('bookings', 'emergency_fee')) {
                $table->integer('emergency_fee')->nullable()->after('is_emergency');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'service_type',
                'address',
                'scheduled_at',
                'status',
                'total_price',
                'completed_at',
                'loyalty_points_used',
                'is_paid',
                'payment_proof',
                'ewallet_type',
                'repair_report',
                'is_emergency',
                'emergency_fee'
            ]);
        });
    }
}; 