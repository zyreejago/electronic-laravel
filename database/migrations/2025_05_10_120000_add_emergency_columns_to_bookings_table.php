<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'is_emergency')) {
                $table->boolean('is_emergency')->default(false);
            }
            if (!Schema::hasColumn('bookings', 'emergency_fee')) {
                $table->integer('emergency_fee')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'is_emergency')) {
                $table->dropColumn('is_emergency');
            }
            if (Schema::hasColumn('bookings', 'emergency_fee')) {
                $table->dropColumn('emergency_fee');
            }
        });
    }
}; 