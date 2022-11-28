<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->tinyInteger('gender');
            // 0: Nam
            // 1: Nữ
            // 2: Khác
            $table->string('phone_number', 15);
            $table->date('dob')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
