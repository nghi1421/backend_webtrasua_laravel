<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topping;
class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topping::create([
            'id' => 1,
            'name' => 'Thêm đào',
            'price' => 7500,
            'active' => 1,
            'drink_id' => 1,
        ]);

        Topping::create([
            'id' => 2,
            'name' => 'Thêm sữa',
            'price' => 5000,
            'active' => 1,
            'drink_id' => 2,
        ]);

        Topping::create([
            'id' => 3,
            'name' => 'Dâu',
            'price' => 8000,
            'active' => 1,
            'drink_id' => 2,
        ]);

        Topping::create([
            'id' => 4,
            'name' => 'Thêm thạch',
            'price' => 7500,
            'active' => 1,
            'drink_id' => 4,
        ]);

        Topping::create([
            'id' => 5,
            'name' => 'Thêm trân châu',
            'price' => 5000,
            'active' => 1,
            'drink_id' => 4,
        ]);

        Topping::create([
            'id' => 6,
            'name' => 'Thêm sữa',
            'price' => 5000,
            'active' => 1,
            'drink_id' => 6,
        ]);

        Topping::create([
            'id' => 8,
            'name' => 'Thêm thạch',
            'price' => 7500,
            'active' => 1,
            'drink_id' => 7,
        ]);

        Topping::create([
            'id' => 9,
            'name' => 'Thêm trân châu',
            'price' => 5000,
            'active' => 1,
            'drink_id' => 7,
        ]);

        Topping::create([
            'id' => 10,
            'name' => 'Thêm lát thơm',
            'price' => 4000,
            'active' => 1,
            'drink_id' => 14,
        ]);

        Topping::create([
            'id' => 11,
            'name' => 'Thêm lát cam',
            'price' => 3000,
            'active' => 1,
            'drink_id' => 13,
        ]);
    }
}
