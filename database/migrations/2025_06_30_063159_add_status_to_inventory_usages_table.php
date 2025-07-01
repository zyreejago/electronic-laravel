<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_usages', function (Blueprint $table) {
            $table->enum('status', ['pending_approval', 'approved', 'rejected', 'used'])
                  ->default('used')
                  ->after('notes');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->text('reason')->nullable()->after('rejection_reason'); // Alasan teknisi menggunakan spare part
        });
    }

    public function down(): void
    {
        Schema::table('inventory_usages', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'reason']);
        });
    }
};