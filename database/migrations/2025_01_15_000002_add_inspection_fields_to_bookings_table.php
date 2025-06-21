<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('damage_description')->nullable()->after('description');
            $table->decimal('estimated_cost', 10, 2)->nullable()->after('damage_description');
            $table->integer('estimated_duration_hours')->nullable()->after('estimated_cost');
            $table->datetime('inspection_completed_at')->nullable()->after('estimated_duration_hours');
            $table->foreignId('inspected_by')->nullable()->constrained('users')->after('inspection_completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'damage_description',
                'estimated_cost',
                'estimated_duration_hours',
                'inspection_completed_at',
                'inspected_by'
            ]);
        });
    }
};