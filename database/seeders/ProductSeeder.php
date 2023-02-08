<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Image;
use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory()->count(15)->create();

        foreach ($products as $key => $product) {
            $categories= Category::factory()->count(rand(1,2))->create();
            $images    = Image::factory()->count(rand(1,4))->create();

            $categories= $categories->map(function ($item, $key) use($product){
                return [
                    'category_id'=>$item->id,
                    'product_id'=> $product->id,
                    'created_at'=> now()->toDateTimeString()
                ];
            });

            $images  = $images->map(function ($item, $key) use($product){
                return [
                    'image_id'=>$item->id,
                    'product_id'=> $product->id,
                    'created_at'=> now()->toDateTimeString()
                ];
            });

            CategoryProduct::insert($categories->toArray());
            ImageProduct::insert($images->toArray());
        }
    }
}
