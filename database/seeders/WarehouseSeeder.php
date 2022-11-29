<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Material;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $new_warehouse = Warehouse::create([
            'name' => 'Kho số 1',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0988888888',
            'date_opened' => '2015-1-5',
            'active' => 1,
        ]);

        $all_material = Material::get();
        foreach($all_material as $material){
            $new_warehouse->materials()->attach($material->id, ['amount'=> 0]);
        }

        $new_warehouse =  Warehouse::create([
            'name' => 'Kho số 2',
            'address' => 'số 1 đường 9, tp Thủ Đức, tp Hồ Chí Minh',
            'phone_number' => '0888123123',
            'date_opened' => '2015-11-5',
            'active' => 1,
        ]);

        foreach($all_material as $material){
            $new_warehouse->materials()->attach($material->id, ['amount'=> 0]);
        }
    }
}
