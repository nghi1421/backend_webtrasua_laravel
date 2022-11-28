<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            // $table->unsignedBigInteger('drink_id');
            // $table->foreign('drink_id')->references('drink_id')->on('drink_details');

            $table->unsignedBigInteger('drink_detail_id');
            $table->foreign('drink_detail_id')->references('id')->on('drink_details');


            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->tinyInteger('quantity')->default(1);

            $table->json('topping_list')->nullable();

            $table->primary(['drink_detail_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
