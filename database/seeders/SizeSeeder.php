<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;
class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Size::create([
            'id' => 1,
            'name' => 'S',
            'ratio' => 1,
        ]);

        Size::create([
            'id' => 2,
            'name' => 'M',
            'ratio' => 1.2,
        ]);
        
        Size::create([
            'id' => 3,
            'name' => 'L',
            'ratio' => 1.4,

        ]);
    }
}
