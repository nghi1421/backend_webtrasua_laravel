<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->default(Carbon::now());;
            $table->boolean('paid')->default(false);
            $table->text('note')->nullable();
            $table->tinyInteger('status');

            //0 hủy
            //1 đã xác nhận
            //2 đang pha chế
            //3 đã pha chế
            //4 đã trả món

            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staffs');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
