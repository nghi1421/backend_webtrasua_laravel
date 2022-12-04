<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'Quản lí'
        ]);

        Role::create([
            'id' => 2,
            'name' => 'Thu ngân'
        ]);
        
        Role::create([
            'id' => 3,
            'name' => 'Bếp'
        ]);

        Role::create([
            'id' => 4,
            'name' => 'Kế toán'
        ]);

        Role::create([
            'id' => 5,
            'name' => 'Quản lí kho'
        ]);

        Role::create([
            'id' => 6,
            'name' => 'Khách hàng'
        ]);
    }
}
