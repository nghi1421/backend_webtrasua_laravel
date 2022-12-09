<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drink;
class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_drink = Drink::create([
            'id' => 1,
            'name' => "Trà dào",
            'slug' => "tra-dao",
            'description' => "Trà đào đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/tra-dao.png",
            'active' => true,
            'tod_id' => 3
        ]);

        $new_drink->materials()->attach(1, ['amount' => 0.045]);
        $new_drink->materials()->attach(2, ['amount' => 0.015]);
        $new_drink->materials()->attach(3, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.01]);
        
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);


        $new_drink = Drink::create([
            'id' => 2,
            'name' => "Hồng trà sữa",
            'slug' => "hong-tra-sua",
            'description' => "Hồng trà sữa đồ uống phù hợp mọi đối tượng",
            'price' => 65000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/hong-tra-sua.png",
            'active' => true,
            'tod_id' => 3
        ]);

        $new_drink->materials()->attach(1, ['amount' => 0.035]);
        $new_drink->materials()->attach(3, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.01]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);

        $new_drink = Drink::create([
            'id' => 3,
            'name' => "Trà xanh Latte",
            'slug' => "tra-xanh-latte",
            'description' => "Trà xanh Latte đồ uống...",
            'price' => 45000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/tra-xanh-latte.png",
            'active' => true,
            'tod_id' => 3
        ]);

        $new_drink->materials()->attach(6, ['amount' => 0.025]);
        $new_drink->materials()->attach(2, ['amount' => 0.03]);
        $new_drink->materials()->attach(4, ['amount' => 0.04]);

               $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3); 
        $new_drink = Drink::create([
            'id' => 4,
            'name' => "Trà sữa Phúc Long",
            'slug' => "tra-sua-phuc-long",
            'description' => "Trà sữa Phúc Long đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/tra-sua-phuc-long.png",
            'active' => true,
            'tod_id' => 1
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.025]);
        $new_drink->materials()->attach(5, ['amount' => 0.035]);
        $new_drink->materials()->attach(2, ['amount' => 0.035]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 5,
            'name' => "Ngọc Viễn Đông",
            'slug' => "ngoc-vien-dong",
            'description' => "Ngọc Viễn Đông đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/ngoc-vien-dong.png",
            'active' => true,
            'tod_id' => 1
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.025]);
        $new_drink->materials()->attach(1, ['amount' => 0.035]);
        $new_drink->materials()->attach(2, ['amount' => 0.035]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 6,
            'name' => "Trà ô long sữa",
            'slug' => "tra-o-long-sua",
            'description' => "Trà ô long sữa đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/tra-o-long-sua.png",
            'active' => true,
            'tod_id' => 1
        ]);

        $new_drink->materials()->attach(6, ['amount' => 0.025]);
        $new_drink->materials()->attach(1, ['amount' => 0.015]);
        $new_drink->materials()->attach(4, ['amount' => 0.045]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 7,
            'name' => "Trà sữa Phúc Long",
            'slug' => "tra-sua-phuc-long",
            'description' => "Trà sữa Phúc Long đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/tra-sua-phuc-long.png",
            'active' => true,
            'tod_id' => 1
        ]);

        $new_drink->materials()->attach(6, ['amount' => 0.025]);
        $new_drink->materials()->attach(5, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 8,
            'name' => "Ngọc Viễn Đông",
            'slug' => "ngoc-vien-dong",
            'description' => "Ngọc Viễn Đông đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/ngoc-vien-dong.png",
            'active' => true,
            'tod_id' => 1
        ]);

        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->materials()->attach(5, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 9,
            'name' => "Cà phê Caramel đá xay",
            'slug' => "ca-phe-caramel",
            'description' => "Cà phê Caramel đá xay đồ uống...",
            'price' => 60000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/ca-phe-caramel-da-xay.png",
            'active' => true,
            'tod_id' => 2
        ]);

        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.035]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 10,
            'name' => "Cà phê Cappuccino đá xay",
            'slug' => "ca-phe-do-cappuccino",
            'description' => "Cà phê Cappuccino đá xay đồ uống...",
            'price' => 70000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/ca-phe-cappuccino-da-xay.png",
            'active' => true,
            'tod_id' => 2
        ]);

        $new_drink->materials()->attach(2, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.045]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 11,
            'name' => "Phin bọt biển",
            'slug' => "phin-bot-bien",
            'description' => "Phin bọt biển đồ uống...",
            'price' => 40000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/phin-bot-bien.png",
            'active' => true,
            'tod_id' => 2
        ]);

        $new_drink->materials()->attach(5, ['amount' => 0.025]);
        $new_drink->materials()->attach(4, ['amount' => 0.015]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 12,
            'name' => "Phin sữa đá",
            'slug' => "phin-sua-da",
            'description' => "Phin sữa đá đồ uống...",
            'price' => 40000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/phin-sua-da-1.png",
            'active' => true,
            'tod_id' => 2
        ]);

        $new_drink->materials()->attach(2, ['amount' => 0.03]);
        $new_drink->materials()->attach(4, ['amount' => 0.015]);
        $new_drink->materials()->attach(1, ['amount' => 0.025]);

        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 13,
            'name' => "Nước ép cam",
            'slug' => "nuoc-ep-cam",
            'description' => "Nước ép cam đồ uống...",
            'price' => 50000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/nuoc-ep-cam.png",
            'active' => true,
            'tod_id' => 4
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.01]);
        $new_drink->materials()->attach(4, ['amount' => 0.015]);
        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 14,
            'name' => "Nước ép thơm",
            'slug' => "nuoc-ep-thom",
            'description' => "Nước ép thơm đồ uống...",
            'price' => 40000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/nuoc-ep-thom.png",
            'active' => true,
            'tod_id' => 4
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.06]);
        $new_drink->materials()->attach(6, ['amount' => 0.03]);
        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 15,
            'name' => "Nước ép táo dâu",
            'slug' => "nuoc-ep-tao-dau",
            'description' => "Nước ép dâu đồ uống...",
            'price' => 45000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/nuoc-ep-tao-va-dau.jpg",
            'active' => true,
            'tod_id' => 4
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.06]);
        $new_drink->materials()->attach(6, ['amount' => 0.03]);
        $new_drink->materials()->attach(2, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 16,
            'name' => "Nước ép táo",
            'slug' => "nuoc-ep-tao",
            'description' => "Nước ép tao đồ uống...",
            'price' => 55000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/nuoc-ep-tao.png",
            'active' => true,
            'tod_id' => 4
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.06]);
        $new_drink->materials()->attach(2, ['amount' => 0.03]);
        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
        $new_drink = Drink::create([
            'id' => 17,
            'name' => "Nước ép bưởi",
            'slug' => "nuoc-ep-buoi",
            'description' => "Nước ép bưởi đồ uống...",
            'price' => 55000,
            'discount' => 0,
            'sales_on_day' => 0,
            'image' => "https://aeonmall-binhduongcanary.com.vn/wp-content/uploads/2020/05/nuoc-ep-buoi.png",
            'active' => true,
            'tod_id' => 4
        ]);

        $new_drink->materials()->attach(3, ['amount' => 0.06]);
        $new_drink->materials()->attach(4, ['amount' => 0.03]);
        $new_drink->materials()->attach(1, ['amount' => 0.025]);
        $new_drink->sizes()->attach(1);
        $new_drink->sizes()->attach(2);
        $new_drink->sizes()->attach(3);
    }
}
