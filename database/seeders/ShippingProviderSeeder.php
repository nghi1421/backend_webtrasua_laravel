<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingProvider;
class ShippingProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingProvider::create([
            'id' => 1,
            'name' => 'ShoppeFood',
        ]);

        ShippingProvider::create([
            'id' => 2,
            'name' => 'Grabfood',
        ]);
    }
}
