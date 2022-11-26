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
            'username' => "allcustomer123",
            'password' => bcrypt("ThanhNghi123`"),
            'role_id' => 6,
        ]);
    }
}
