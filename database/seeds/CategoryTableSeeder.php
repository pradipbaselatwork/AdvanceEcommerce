<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>5,'parent_id'=>1,'section_id'=>1,'category_name'=>'Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'shirts','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
        Category::insert($categoryRecords);
    }
}
