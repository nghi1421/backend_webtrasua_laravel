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
            'name' => 'Quản lí'
        ]);
        Role::create([
            'name' => 'Thu ngân'
        ]);
        Role::create([
            'name' => 'Bếp'
        ]);
        Role::create([
            'name' => 'Kế toán'
        ]);
        Role::create([
            'name' => 'Quản lí kho'
        ]);
    }
}
