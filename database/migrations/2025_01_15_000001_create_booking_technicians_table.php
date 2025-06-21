<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_technicians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['lead', 'assistant'])->default('assistant');
            $table->timestamps();
            
            $table->unique(['booking_id', 'technician_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_technicians');
    }
};