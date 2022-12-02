<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::create([
            'id' => 1,
            'address' => '90 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 1,
        ]);
        Address::create([
            'id' => 2,
            'address' => '91 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 1,
        ]);
        Address::create([
            'id' => 3,
            'address' => '92 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 1,
        ]);
        Address::create([
            'id' => 4,
            'address' => '93 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 1,
        ]);
        Address::create([
            'id' => 5,
            'address' => '94 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 1,
        ]);

        Address::create([
            'id' => 6,
            'address' => '1 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 2,
        ]);
        Address::create([
            'id' => 7,
            'address' => '2 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 2,
        ]);
        Address::create([
            'id' => 8,
            'address' => '33 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 2,
        ]);
        Address::create([
            'id' => 9,
            'address' => '22 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 2,
        ]);
        Address::create([
            'id' => 10,
            'address' => '55 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 2,
        ]);

        Address::create([
            'id' => 11,
            'address' => '22 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 3,
        ]);
        Address::create([
            'id' => 12,
            'address' => '55 Man Thien, phuong Hiep Phu, Tp Thu Duc, Tp Ho Chi Minh',
            'customer_id' => 3,
        ]);
    }
}
