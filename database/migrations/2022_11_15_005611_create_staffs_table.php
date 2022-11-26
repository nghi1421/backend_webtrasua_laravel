<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->tinyInteger('gender');
            // 0: Nam
            // 1: Nữ
            // 2: Khác
            $table->string('phone_number', 15)->unique();
            $table->string('address', 200);
            $table->date('dob')->nullable();
            $table->string('hometown',100);
            $table->boolean('active');

            $table->unsignedBigInteger('id_login')->nullable();
            $table->foreign('id_login')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
