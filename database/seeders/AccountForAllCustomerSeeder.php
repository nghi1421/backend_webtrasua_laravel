<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class AccountForAllCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'email' => "admin123@gmail.com",
            'password' => bcrypt("ThanhNghi123`"),
            'role_id' => 1,
        ]);
        User::create([
            'id' => 2,
            'email' => "allcustomer123@gmail.com",
            'password' => bcrypt("ThanhNghi123`"),
            'role_id' => 6,
        ]);
    }
}
