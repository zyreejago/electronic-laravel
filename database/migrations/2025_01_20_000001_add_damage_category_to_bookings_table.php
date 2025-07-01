<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('damage_category')->nullable()->after('description');
            $table->string('item_condition')->nullable()->after('damage_category');
            $table->text('accessories_included')->nullable()->after('item_condition');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['damage_category', 'item_condition', 'accessories_included']);
        });
    }
};