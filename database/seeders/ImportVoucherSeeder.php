<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImportVoucher;

class ImportVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_impvou = ImportVoucher::create([
            'id' => 1,
            'created_at' => '2022-12-8',
            'status' => 1,
            'staff_id' => 1,
            'warehouse_id' => 1,
            'provider_id' => 1
        ]);

        $new_impvou->materials()->attach(1, ['amount' => 2]);
        $new_impvou->materials()->attach(2, ['amount' => 1]);


        $new_impvou = ImportVoucher::create([
            'id' => 2,
            'created_at' => '2022-12-1',
            'status' => 0,
            'staff_id' => 1,
            'warehouse_id' => 1,
            'provider_id' => 1
        ]);

        $new_impvou->materials()->attach(1, ['amount' => 2]);
        $new_impvou->materials()->attach(3, ['amount' => 1]);

        $new_impvou = ImportVoucher::create([
            'id' => 3,
            'created_at' => '2022-12-8',
            'status' => 1,
            'staff_id' => 1,
            'warehouse_id' => 1,
            'provider_id' => 1
        ]);

        $new_impvou->materials()->attach(1, ['amount' => 2]);
        $new_impvou->materials()->attach(4, ['amount' => 2]);
    }
}
