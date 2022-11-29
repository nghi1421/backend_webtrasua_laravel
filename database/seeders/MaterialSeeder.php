<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::create([
            'id' => 1,
            'name' =>  'Sữa',
            'uom' =>  'kg',
        ]);

        Material::create([
            'id' => 2,
            'name' =>  'Đá',
            'uom' =>  'kg',
        ]);

        Material::create([
            'id' => 3,
            'name' =>  'Đường',
            'uom' =>  'kg',
        ]);

        Material::create([
            'id' => 4,
            'name' =>  'Trứng',
            'uom' =>  'quả',
        ]);

        Material::create([
            'id' => 5,
            'name' =>  'Trà',
            'uom' =>  'kg',
        ]);

        Material::create([
            'id' => 6,
            'name' =>  'Cà phê',
            'uom' =>  'kg',
        ]);
    }
}
