<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Material;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_branch = Branch::create([
            'name'  => 'Chi nhánh Lê Văn Việt',
            'address'  => '22 Lê Văn Việt, phường Tăng Nhơn Phú B, tp Thủ Đức, tp Hồ Chí Minh', 
            'phone_number'  => '0822341222',
            'date_opened' => '2015-02-02',
            'active' => true,
        ]);

        
        $all_material = Material::get();
        foreach($all_material as $material){
            $new_branch->materials()->attach($material->id, ['amount'=> 0]);
        }

        $new_branch = Branch::create([
            'name'  => 'Chi nhánh Nam Kì Khởi nghĩa',
            'address'  => '133 Nam Kì Khởi nghĩa, phường 2, quận Bình Thạnh, tp Hồ Chí Minh', 
            'phone_number'  => '0811223322',
            'date_opened' => '2017-09-12',
            'active' => true,
        ]);

        foreach($all_material as $material){
            $new_branch->materials()->attach($material->id, ['amount'=> 0]);
        }
        $new_branch = Branch::create([
            'name'  => 'Chi nhánh Hồng Bàng',
            'address'  => '66 Hồng Bàng, phường 10, quận 5, tp Hồ Chí Minh', 
            'phone_number'  => '0123123123',
            'date_opened' => '2018-01-22',
            'active' => true,
        ]);
        foreach($all_material as $material){
            $new_branch->materials()->attach($material->id, ['amount'=> 0]);
        }
    }
}
