<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;
class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
            'id' => 1,
            'name' => 'Nha chung cap so 1',
            'address' => 'Tp Hai Phong',
            'phone_number' => '0987111333'
        ]);

        Provider::create([
            'id' => 2,
            'name' => 'Nha cung cap so 2',
            'address' => 'Tp Ho Chi Minh',
            'phone_number' => '0999888777'
        ]);

        Provider::create([
            'id' => 3,
            'name' => 'Nha cung cap so 3',
            'address' => 'Tp Ho Chi Minh',
            'phone_number' => '0112223444'
        ]);

        Provider::create([
            'id' => 4,
            'name' => 'Nha cung cap so 4',
            'address' => 'Ha Noi',
            'phone_number' => '0987776622'
        ]);

    }
}
