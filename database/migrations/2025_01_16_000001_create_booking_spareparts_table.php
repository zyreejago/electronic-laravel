<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->string('sparepart_name');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['used', 'returned', 'damaged'])->default('used');
            $table->text('notes')->nullable();
            $table->timestamp('used_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_spareparts');
    }
};