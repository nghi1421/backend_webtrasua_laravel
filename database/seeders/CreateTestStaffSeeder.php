<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class CreateTestStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::create([
            'name' => "testing api",
            'gender' => 1,
            'phone_number' => "0123123123",
            'address' => "Test",
            'dob' => '2001-4-1',
            'hometown' => 'An Giang',
            'active' => 1,
            'branch_id' => 1,
            'position_id' => 1,
            'id_login' => 1,
        ]);
        Staff::create([
            'name' => "Nguyen Thanh N",
            'gender' => 1,
            'phone_number' => "0223344222",
            'address' => "Test",
            'dob' => '2001-4-1',
            'hometown' => 'An Giang',
            'active' => 1,
            'branch_id' => 1,
            'position_id' => 2,

        ]);
        Staff::create([
            'name' => "Trần Thị Thùy L",
            'gender' => 1,
            'phone_number' => "0888222333",
            'address' => "Test",
            'dob' => '2002-1-1',
            'hometown' => 'Tp Hồ CHí Minh',
            'active' => 1,
            'branch_id' => 1,
            'position_id' => 3,
        ]);
        Staff::create([
            'name' => "Lê Hoàng K",
            'gender' => 1,
            'phone_number' => "0999224621",
            'address' => "Test",
            'dob' => '2001-4-1',
            'hometown' => 'Tp Hồ CHí Minh',
            'active' => 1,
            'branch_id' => 1,
            'position_id' => 4,
        ]);
        Staff::create([
            'name' => "Đinh Văn B",
            'gender' => 1,
            'phone_number' => "0998712322",
            'address' => "Test",
            'dob' => '2001-4-1',
            'hometown' => 'Tp Hồ CHí Minh',
            'active' => 1,
            'branch_id' => 1,
            'position_id' => 5,
        ]);
    }
}
