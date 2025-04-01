<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts','vendor_id')) {
                $table->integer('vendor_id')->nullable();
            }
            $table->integer('points')->default(0);
            $table->integer('used')->default(0);
            $table->string('coupon_type')->nullable();
            $table->integer('coupon_value')->default(0);
            $table->date('active_to')->nullable();
            $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
