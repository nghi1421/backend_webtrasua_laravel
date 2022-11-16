<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('slug',100);
            $table->text('description')->nullable();
            $table->decimal('price',15,2);
            $table->decimal('discount',10,4)->default(0);
            $table->tinyInteger('sales_on_day');
            $table->text('image');
            $table->boolean('active');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drinks');
    }
}
