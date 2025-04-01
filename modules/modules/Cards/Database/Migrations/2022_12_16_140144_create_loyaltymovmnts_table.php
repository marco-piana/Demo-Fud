<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltymovmntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalycards', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('companies');
            
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users');
        
            $table->float('points',12,2)->default(0)->comment('Current points state');

            $table->string('card_id')->nullable()->default('')->comment('ID of the card');

            $table->timestamps();
        });
        
        Schema::create('loyaltymovments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('companies');
            
            $table->unsignedBigInteger('loyalycard_id');
            $table->foreign('loyalycard_id')->references('id')->on('loyalycards');
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->float('order_value',12,2)->default(0)->nullable()->comment('Value of the order in currencies');

            $table->float('value',12,2)->default(0)->comment('Value of the movement in points');

            $table->integer('type')->default(1)->comment('0:spent, 1:add');
            $table->float('newstate',12,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyaltymovmnts');
    }
}
