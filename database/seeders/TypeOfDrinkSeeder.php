<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeOfDrink;

class TypeOfDrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfDrink::create([
            'id' => 1,
            'name' => 'Trà sữa',
        ]);
        TypeOfDrink::create([
            'id' => 2,
            'name' => 'Cà phê',
        ]);
        TypeOfDrink::create([
            'id' => 3,
            'name' => 'Trà',
        ]);
        TypeOfDrink::create([
            'id' => 4,
            'name' => 'Nước ép',
        ]);
    }
}
