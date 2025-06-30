<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama barang
            $table->text('description')->nullable();
            $table->integer('stock_quantity')->default(0); // Jumlah stok
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->enum('condition', ['Layak Pakai', 'Tidak Layak'])->default('Layak Pakai');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->integer('minimum_stock')->default(5); // Batas minimum stok
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};