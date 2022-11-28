<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_details', function (Blueprint $table) {
            $table->unsignedBigInteger('drink_id');
            $table->foreign('drink_id')->references('id')->on('drinks');

            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('id')->on('sizes');
            
            $table->id();
            // $table->foreignId('size_id')->constained('sizes');
            // $table->foreignId('drink_id')->constained('drinks');

            $table->unique(['drink_id', 'size_id']);

            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drink_details');
    }
}
