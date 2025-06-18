<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_service_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_component_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('price_at_time'); // Price in Rupiah at the time of booking
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_service_components');
    }
}; 