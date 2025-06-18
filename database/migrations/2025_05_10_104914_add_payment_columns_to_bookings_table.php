<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        if (!Schema::hasColumn('bookings', 'is_paid')) {
            $table->boolean('is_paid')->default(false); // tanpa after
        }
        if (!Schema::hasColumn('bookings', 'payment_proof')) {
            $table->string('payment_proof')->nullable();
        }
        if (!Schema::hasColumn('bookings', 'ewallet_type')) {
            $table->enum('ewallet_type', ['ovo', 'dana', 'gopay', 'spay'])->nullable();
        }
        // dst.
    });
}
 
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['is_paid', 'payment_proof', 'ewallet_type']);
            // Kolom lain yang ditambah juga di-drop di sini
        });
    }
};
