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
            'name' => "Trần Văn C",
            'gender' => 0,
            'phone_number' => '0111222333',
            'active' => true
        ]);
        Customer::create([
            'name' => "Lê Văn C",
            'gender' => 0,
            'phone_number' => '0123122222',
            'active' => true
        ]);
        Customer::create([
            'name' => "Nguyễn Văn C",
            'gender' => 0,
            'phone_number' => '0111888777',
            'active' => true
        ]);
        Customer::create([
            'name' => "Trương Hoàng S",
            'gender' => 0,
            'phone_number' => '0123777334',
            'active' => true
        ]);
    }
}
