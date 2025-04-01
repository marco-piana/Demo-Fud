<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plan', function (Blueprint $table) {
            $table->tinyInteger('can_pickup')->default(1)->after('enable_ordering');
            $table->tinyInteger('can_deliver')->default(1)->nullable(false)->after('can_pickup');
            $table->tinyInteger('free_deliver')->default(1)->nullable(false)->after('can_deliver');
            $table->tinyInteger('order_table')->default(1)->nullable(false)->after('free_deliver');
            $table->tinyInteger('table_reservation')->default(1)->nullable(false)->after('order_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan', function (Blueprint $table) {
            //
        });
    }
};
