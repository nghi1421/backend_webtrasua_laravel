<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => "Tran Van C",
            'gender' => 0,
            'phone_number' => '0111222333',
            'active' => true
        
        ]);
    }
}
