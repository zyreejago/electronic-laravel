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
    Schema::table('service_components', function (Blueprint $table) {
        $table->boolean('is_available')->default(true)->after('stock');
    });
}

public function down()
{
    Schema::table('service_components', function (Blueprint $table) {
        $table->dropColumn('is_available');
    });
}
};
