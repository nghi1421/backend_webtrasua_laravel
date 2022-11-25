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
        ]);
    }
}
