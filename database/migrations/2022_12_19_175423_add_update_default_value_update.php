<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUpdateDefaultValueUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('created_at')->default('CURRENT_TIMESTAMP')->change();
        });

        Schema::table('supply_vouchers', function (Blueprint $table) {
            $table->timestamp('created_at')->default('CURRENT_TIMESTAMP')->change();
        });

        Schema::table('import_vouchers', function (Blueprint $table) {
            $table->timestamp('created_at')->default('CURRENT_TIMESTAMP')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
