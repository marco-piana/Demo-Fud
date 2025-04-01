<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reservation_code')->unique();

            $table->unsignedBigInteger('customer_id');


            $table->foreignId('table_id')->nullable();
            $table->date('reservation_date')->default(date('Y-m-d'));
            $table->time('reservation_time');
            $table->string('created_by')->default('customer'); // Default created by as 'customer' Possible values: customer, staff, system
            $table->string('created_by_user_id')->nullable(); // User ID of the staff who created the reservations
           
            $table->string('status')->default('pending'); // Default status as 'pending' Possible values: pending, confirmed, canceled, seated, soon, late, no-show
            $table->unsignedInteger('number_of_guests')->default(1);
            $table->text('special_requests')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('expected_occupancy')->nullable()->default(30); // Number of minutes
            $table->timestamp('seated_at')->nullable();
            $table->timestamp('expected_leave')->nullable();
            
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
        Schema::dropIfExists('reservations');
    }
}
