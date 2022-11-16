<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateSupplyVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_vouchers', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->default(Carbon::now());
            $table->tinyInteger('status');
            //0  hủy
            //1 đã xác nhận
            //2 chờ vận chuyển
            //3 đang kiểm tra
            //4 hoàn tất

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
        Schema::dropIfExists('supply_vouchers');
    }
}
