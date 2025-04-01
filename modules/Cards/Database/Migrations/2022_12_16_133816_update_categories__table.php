<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table already exists
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                // Define your table columns here
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
                $table->integer('order_index')->default(0);
                $table->integer('active')->default(1);
                $table->softDeletes();

                $table->integer('percent')->default(0);
                $table->integer('staticpoints')->default(0);
                $table->integer('threshold')->default(0);

                $table->unsignedBigInteger('company_id');
                $table->index('company_id');
                $table->foreign('company_id')->references('id')->on('companies');
            });
        }else{
            Schema::table('categories', function (Blueprint $table) {
                $table->integer('percent')->default(0);
                $table->integer('staticpoints')->default(0);
                $table->integer('threshold')->default(0);
            });
        }

       
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
