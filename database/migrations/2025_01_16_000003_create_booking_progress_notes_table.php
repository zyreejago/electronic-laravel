<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_progress_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['progress', 'issue', 'milestone', 'customer_contact', 'parts_needed']);
            $table->string('title');
            $table->text('description');
            $table->json('attachments')->nullable(); // untuk foto progress
            $table->enum('visibility', ['internal', 'customer'])->default('internal'); // apakah customer bisa lihat
            $table->integer('progress_percentage')->nullable(); // 0-100
            $table->timestamp('noted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_progress_notes');
    }
};