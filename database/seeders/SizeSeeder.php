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
            'name' => 'S',
            'ratio' => 1,
        ]);

        Size::create([
            'name' => 'S',
            'ratio' => 1.2,
        ]);
        
        Size::create([
            'name' => 'L',
            'ratio' => 1.4,

        ]);
    }
}
