<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BranchSeeder::class);
        // $this->call(PositionSeeder::class);
        // $this->call(SizeSeeder::class);
        // $this->call(WarehouseSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(CreateTestStaffSeeder::class);
        // $this->call(CreateTestStaffSeeder::class);
        // $this->call(CustomerSeeder::class);
        $this->call(AccountForAllCustomerSeeder::class);
    }
}
