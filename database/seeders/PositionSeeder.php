<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'Quản lí'
        ]);
        
        Position::create([
            'name' => 'Thu ngân'
        ]);
        
        Position::create([
            'name' => 'Bếp'
        ]);
        
        Position::create([
            'name' => 'Kế toán'
        ]);
        
        Position::create([
            'name' => 'Quản lí kho'
        ]);
        
        Position::create([
            'name' => 'Bảo vệ'
        ]);
        
        Position::create([
            'name' => 'Phục vụ'
        ]);
        
        Position::create([
            'name' => 'Vệ sinh'
        ]);
        

    }
}
