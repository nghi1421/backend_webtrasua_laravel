<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::create([
            'name' => 'Kho số 1',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0988888888',
            'date_opened' => '2015-1-5',
            'active' => 1,
        ]);

        Warehouse::create([
            'name' => 'Kho số 2',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0888123123',
            'date_opened' => '2015-11-5',
            'active' => 1,
        ]);

        Warehouse::create([
            'name' => 'Kho số 3',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0987222333',
            'date_opened' => '2015-5-5',
            'active' => 1,
        ]);

        Warehouse::create([
            'name' => 'Kho số 4',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0988992223',
            'date_opened' => '2016-1-5',
            'active' => 1,
        ]);

    }
}
